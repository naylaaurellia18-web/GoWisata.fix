<?php
$host   = getenv('TIDB_HOST')     ?: 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$port   = getenv('TIDB_PORT')     ?: '4000';
$dbname = getenv('TIDB_DATABASE') ?: 'gowisata2';
$user   = getenv('TIDB_USER')     ?: '2TfJGdFNKpGMfMM.root';
$pass   = getenv('TIDB_PASSWORD') ?: 'ZGN76i1wcAXPurFo';

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
$ok = mysqli_real_connect($conn, $host, $user, $pass, $dbname, (int)$port, NULL, MYSQLI_CLIENT_SSL);

if (!$ok) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Alias agar file lain yang pakai $koneksi tetap jalan
$koneksi = $conn;

// Buat tabel session otomatis jika belum ada
// BUG #FIX FATAL: TiDB (dan MySQL strict mode) TIDAK mengizinkan DEFAULT value
// pada kolom bertipe BLOB/TEXT/JSON. Menghapus DEFAULT '' adalah satu-satunya solusi.
// Nilai kosong sudah ditangani oleh method read() pada DbSessionHandler di bawah.
mysqli_query($conn,
    "CREATE TABLE IF NOT EXISTS php_sessions (
        session_id   VARCHAR(128) NOT NULL PRIMARY KEY,
        session_data LONGTEXT     NOT NULL,
        session_expiry BIGINT     NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
);

// ============================================================
// Custom Session Handler — menyimpan session di TiDB
// ============================================================
class DbSessionHandler implements SessionHandlerInterface {
    private $db;
    private $lifetime;

    public function __construct($db) {
        $this->db       = $db;
        $this->lifetime = (int)ini_get('session.gc_maxlifetime') ?: 1440;
    }

    public function open($path, $name): bool { return true; }
    public function close(): bool           { return true; }

    public function read($id): string {
        $id     = mysqli_real_escape_string($this->db, $id);
        $result = mysqli_query($this->db,
            "SELECT session_data FROM php_sessions
             WHERE session_id = '$id' AND session_expiry > " . time()
        );
        if ($result && $row = mysqli_fetch_assoc($result)) {
            return (string)$row['session_data'];
        }
        return '';
    }

    public function write($id, $data): bool {
        $id     = mysqli_real_escape_string($this->db, $id);
        $data   = mysqli_real_escape_string($this->db, $data);
        $expiry = time() + $this->lifetime;
        mysqli_query($this->db,
            "REPLACE INTO php_sessions (session_id, session_data, session_expiry)
             VALUES ('$id', '$data', $expiry)"
        );
        return true;
    }

    public function destroy($id): bool {
        $id = mysqli_real_escape_string($this->db, $id);
        mysqli_query($this->db, "DELETE FROM php_sessions WHERE session_id = '$id'");
        return true;
    }

    public function gc($maxlifetime): int {
        mysqli_query($this->db, "DELETE FROM php_sessions WHERE session_expiry < " . time());
        return (int)mysqli_affected_rows($this->db);
    }
}

// Daftarkan handler SEBELUM session_start() dipanggil
if (session_status() === PHP_SESSION_NONE) {
    session_set_save_handler(new DbSessionHandler($conn), true);
}
?>