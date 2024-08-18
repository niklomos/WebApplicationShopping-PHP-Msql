
    // JavaScript สำหรับปุ่ม Back to Top
// เมื่อผู้ใช้เลื่อนหน้าเว็บลง แสดงหรือซ่อนปุ่มตามการเลื่อน
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    document.getElementById("myBtn").style.display = "block";
  } else {
    document.getElementById("myBtn").style.display = "none";
  }
}

// เมื่อผู้ใช้คลิกปุ่ม Back to Top ให้เลื่อนขึ้นไปที่ด้านบนของหน้าเว็บ
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

