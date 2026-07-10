$(document).ready(function() {
    console.log("jQuery is ready and loaded successfully!");

    $("#expense-form").on("submit", function(event) {
        let title = $("#title").val().trim();
        let amount = $("#amount").val().trim();
        let category = $("#category").val();
        let date = $("#date").val();

        let isValid = true;
        $(".form-control").css("border-color", "#d1d5db");

        if (title === "") {
            $("#title").css("border-color", "#ef4444");
            isValid = false;
        }
        if (amount === "" || isNaN(amount) || parseFloat(amount) <= 0) {
            $("#amount").css("border-color", "#ef4444");
            isValid = false;
            alert("Please enter a valid positive amount!");
        }
        if (category === "") {
            $("#category").css("border-color", "#ef4444");
            isValid = false;
        }
        if (date === "") {
            $("#date").css("border-color", "#ef4444");
            isValid = false;
        }
        if (!isValid) {
            event.preventDefault();
        }
    });
    $(".btn-delete").on("click", function(event) {
        let confirmDelete = confirm("Are you sure you want to delete this expense?");
        
        if (!confirmDelete) {
            event.preventDefault();
        }
    });
});
