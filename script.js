/* ================= LOGIN ================= */
// Fungsi ini tidak dipakai karena login sudah ditangani oleh prosesLogin.php (form PHP)
// Dibiarkan untuk keperluan kompatibilitas jika ada halaman yang memanggilnya
function loginUser(event){
    event.preventDefault();
    let username = document.getElementById("loginUsername").value;
    let password = document.getElementById("loginPassword").value;
    let storedUser = localStorage.getItem("username");
    let storedPass = localStorage.getItem("password");
    
    if(username !== storedUser){
        alert("Username tidak ditemukan");
        return;
    }
    if(password !== storedPass){
        alert("Password salah");
        return;
    }
    alert("Login berhasil!");
    window.location.href = "destinasi.php";
}

/* ================= REGISTER ================= */
function registerUser(event){
    event.preventDefault();
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    localStorage.setItem("username", username);
    localStorage.setItem("password", password);
    alert("Akun berhasil dibuat! Silakan login.");
    showLogin();
}

/* ================= SWITCH FORM ================= */
function showRegister(){
    document.getElementById("loginForm").style.display = "none";
    document.getElementById("registerForm").style.display = "block";
}

function showLogin(){
    document.getElementById("loginForm").style.display = "block";
    document.getElementById("registerForm").style.display = "none";
}

/* ================= PESAN TIKET ================= */
function pesanTiket(tempat, harga){
    localStorage.setItem("destinasi", tempat);
    localStorage.setItem("harga", harga);
    window.location.href = "pesan.php";
}

/* ================= CEK USER LOGIN & INISIALISASI ================= */
// BUG #11 FIX: Sebelumnya document.getElementById("destinasi") dipanggil
// di LUAR window.onload — ini langsung error di semua halaman yang tidak
// memiliki elemen dengan id="destinasi" (semua halaman kecuali satu).
// Sekarang dibungkus dalam window.onload + pengecekan null agar aman.
window.onload = function(){
    let username = localStorage.getItem("username");
    if(username){
        console.log("User login:", username);
    }

    // Isi teks destinasi hanya jika elemen tersebut ADA di halaman ini
    let elDestinasi = document.getElementById("destinasi");
    if(elDestinasi){
        elDestinasi.innerText = localStorage.getItem("destinasi");
    }
}

function pesanSukses(){
    alert("Tiket berhasil dipesan 🎉");
}