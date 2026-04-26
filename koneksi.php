$conn = @mysqli_connect("localhost", "root", "", "gowisata2");

if (!$conn) {
    echo "Sistem Online (Database belum terhubung ke Cloud)";
    exit();
}