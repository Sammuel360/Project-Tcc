document.getElementById("sidebarCollapse").onclick = function () {
    var sidebar = document.getElementById("sidebar");
    var content = document.getElementById("content");
    sidebar.classList.toggle("active");
    content.classList.toggle("shifted");
};
