@vite(['resources/css/reusable/confirmation.css'])
<div id="confirmBox">
    <div class="darkednedBackground">
        <div id="confirmation-box">
            <div id="confirmation-close"></div>
            <h1 id="confirmation-title">CONFIRMATION</h1><br>
            <p id="confirmation-text">Are you sure you want to perform action?</p>
            <span>
                <button class="confirmation-buttons" id="confirmation-cancel-button">CANCEL</button>
                <form id="confirmation-form" action="" method="POST">
                    @csrf
                    <button type="submit" class="confirmation-buttons" id="confirmation-confirm-button">CONFIRM</button>
                </form>
            </span>
        </div>
    </div>
</div>
@vite(['resources/js/reusable/confirmation.js'])
<script>
    const confirm = document.getElementById("confirmation-form");
    const confirm_text = document.getElementById("confirmation-text");

    function showConfirm(action, warning) {
        const confirmBox = document.getElementById("confirmBox");
        confirmBox.style.display = "block";
        if (confirm_text) confirm_text.innerHTML = (warning !== 'string') ? warning : 'Are you sure you want to perform action?';
        if (typeof(action) === 'string') confirm.action = action;
    }
</script>