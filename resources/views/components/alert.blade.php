<div class="container mt-3">
    <div class="d-flex justify-content-center align-items-center">
        <button class="btn btn-warning" onclick="showAlert()">Show Alert</button>
    </div>
    <div id="alertContainer" class="mt-3"></div>
</div>

<script>
    function showAlert() {
        let alertDiv = document.createElement("div");
        alertDiv.className = "alert alert-warning alert-dismissible fade show";
        alertDiv.setAttribute("role", "alert");
        alertDiv.innerHTML = `
            <strong>Selamat Datang di Toko Mas Diyas</strong> Temukan sepatu impianmu disini
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.getElementById("alertContainer").appendChild(alertDiv);
    }
</script>
