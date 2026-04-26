/* ================= LOGIN ================= */

function loginUser(event){
    event.preventDefault()
    let username = document.getElementById("loginUsername").value
    let password = document.getElementById("loginPassword").value
    let storedUser = localStorage.getItem("username")
    let storedPass = localStorage.getItem("password")
    
    if(username !== storedUser){
        alert("Username tidak ditemukan")
        return
    }
    
    if(password !== storedPass){
        alert("Password salah")
        return
    }
    alert("Login berhasil!")

// pindah ke halaman destinasi
  `<script>window.location.href = "destinasi.php"</script>`;
}

/* ================= REGISTER ================= */

function registerUser(event){
    event.preventDefault()
    let username = document.getElementById("username").value
    let password = document.getElementById("password").value
    localStorage.setItem("username", username)
    localStorage.setItem("password", password)
    alert("Akun berhasil dibuat! Silakan login.")
    showLogin()
}

/* ================= SWITCH FORM ================= */

function showRegister(){
    document.getElementById("loginForm").style.display = "none"
    document.getElementById("registerForm").style.display = "block"
}

function showLogin(){
    document.getElementById("loginForm").style.display = "block"
    document.getElementById("registerForm").style.display = "none"
}

/* ================= PESAN TIKET ================= */

function pesanTiket(tempat, harga){
    localStorage.setItem("destinasi", tempat)
    localStorage.setItem("harga", harga)

    window.location.href = "pesan.php"
}

/* ================= CEK USER LOGIN ================= */

window.onload = function(){
    let username = localStorage.getItem("username")
    if(username){
        console.log("User login:", username)
    }
}

    document.getElementById("destinasi").innerText =localStorage.getItem("destinasi")

function pesanSukses(){
        alert("Tiket berhasil dipesan 🎉")
}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// 1. Tambahkan variabel global untuk menampung pilihan user
let wisataTerpilih = "";
let hargaTerpilih = "";

// 2. Tambahkan fungsi pesanTiket yang hilang
function pesanTiket(nama, harga) {
    wisataTerpilih = nama;
    hargaTerpilih = harga;
    
    // Tampilkan info di dalam modal
    document.getElementById('infoTiket').innerHTML = `Anda akan memesan tiket <br><b>${nama}</b> seharga <b>Rp ${parseInt(harga).toLocaleString('id-ID')}</b>`;
    
    // Munculkan modal konfirmasi
    var myModal = new bootstrap.Modal(document.getElementById('tiketModal'));
    myModal.show();
}

// 3. Fungsi lanjut ke halaman pesan (yang sudah kita buat tadi)
function lanjutBayar() {
    let diskon = "<?= isset($_SESSION['promo_aktif']) ? $_SESSION['promo_aktif']['diskon'] : 0; ?>";
    let potongan = "<?= isset($_SESSION['promo_aktif']) ? $_SESSION['promo_aktif']['potongan'] : 0; ?>";
    let kode = "<?= isset($_SESSION['promo_aktif']) ? $_SESSION['promo_aktif']['kode'] : ''; ?>";
    
    let url = "pesan.php?wisata=" + encodeURIComponent(wisataTerpilih) + 
              "&harga=" + hargaTerpilih + 
              "&diskon=" + diskon + 
              "&potongan=" + potongan + 
              "&kode=" + kode;

    window.location.href = url;
}
</script>