const confirmButton = document.getElementById("confirmation-confirm-button");
const cancelButton = document.getElementById("confirmation-cancel-button");

document.getElementById("confirmation-close").addEventListener('click', () => {
    const confirmBox = document.getElementById("confirmBox");
    confirmBox.style.display = "none";
});

cancelButton.addEventListener('click', () => {
    const confirmBox = document.getElementById("confirmBox");
    confirmBox.style.display = "none";
    confirmButton.removeAttribute('onclick');
});