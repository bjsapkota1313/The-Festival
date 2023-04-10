<div id="registerModal" class="modal">
    <div class="modal-content">
        <h4>Payment Error!</h4>
        <p>Sorry We were not able to complete your payment. If you press yes, you will redirect to shopping cart</p>
        <button id="yesBtn">Yes</button>
    </div>
</div>

<script>
    var modal = document.getElementById("registerModal");
    var yesBtn = document.getElementById("yesBtn");
    yesBtn.onclick = function() {
        window.location.href = "/festival/shoppingCart";
    }
    modal.style.display = "block";
</script>
<style>
    /* Modal Styles */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 30%; /* set the width to 40% */
        max-width: 400px; /* limit the maximum width to 600px */
    }

    .modal {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content h4 {
        margin-top: 0;
    }

    .modal-content p {
        margin-bottom: 20px;
    }

    .modal-content button {
        background-color: #4CAF50;
        color: white;
        padding: 6px 12px; /* decrease the padding */
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: auto;
        width: 120px;
        margin-bottom: 10px;
        justify-content: center;
    }

    .modal-content button:hover {
        background-color: #3e8e41;
    }
</style>
