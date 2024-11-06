document.addEventListener("DOMContentLoaded", function() {
    const popup = document.getElementById("claimPopup");
    const overlay = document.getElementById("overlay");
    const closePopup = document.getElementById("closePopup");
    const confirmClaimButton = document.getElementById("confirmClaimButton");
    const cancelButton = document.getElementById("cancelButton");
    const voucherNameElement = document.getElementById("voucherName");
    let selectedVoucherId = null;
    let selectedVoucherName = "";

    // Function to show the popup and set the voucher name
    window.showPopup = function(voucherId, voucherName) {
        selectedVoucherId = voucherId;
        selectedVoucherName = voucherName;
        voucherNameElement.textContent = selectedVoucherName;
        popup.style.display = "block";
        overlay.style.display = "block";
    };

    function hidePopup() {
        popup.style.display = "none";
        overlay.style.display = "none";
        selectedVoucherId = null;
        selectedVoucherName = "";
    }

    closePopup.addEventListener("click", hidePopup);
    cancelButton.addEventListener("click", hidePopup);

    window.addEventListener("click", function(event) {
        if (event.target === overlay) hidePopup();
    });

    confirmClaimButton.addEventListener("click", function() {
        if (selectedVoucherId) {
            claimVoucher(selectedVoucherId);
            hidePopup();
        }
    });

    // Function to claim the voucher via AJAX
    function claimVoucher(voucherId) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "ClaimVoucher.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                location.reload(); // Refresh the page to show updated points and vouchers
            } else {
                alert(response.message);
            }
        };
        xhr.onerror = function () {
            alert("An error occurred during the AJAX request.");
        };
        xhr.send("voucherid=" + encodeURIComponent(voucherId));
    }
});








