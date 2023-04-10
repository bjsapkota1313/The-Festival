<!--<div id="confirm-dialog" class="modal fade">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h4 class="modal-title">Confirmation</h4>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <p>You need to login or register to continue. Do you want to go to the login/register page?</p>-->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>-->
<!--                <a href="/login/registerUser" class="btn btn-primary">Yes</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<script>-->
<!--    $(document).ready(function() {-->
<!--        $("#confirm-dialog").modal("show");-->
<!--        $("#confirm-dialog .btn-primary").click(function() {-->
<!--            window.location.href = "/login/registerUser";-->
<!--        });-->
<!--    });-->
<!--</script>-->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <h4>Register Now?</h4>
        <p>You need to register an account to continue</p>
        <button id="RegisterBtn">Register</button>
        <button id="loginBtn">Login</button>
        <button id="noBtn">No</button>
    </div>
</div>

<script>
    var modal = document.getElementById("registerModal");
    var registerBtn = document.getElementById("RegisterBtn");
    var loginBtn = document.getElementById("loginBtn");
    var noBtn = document.getElementById("noBtn");
    registerBtn.onclick = function() {
        window.location.href = "/login/registerUser";
    }
    loginBtn.onclick = function() {
        window.location.href = "/login";
    }
    noBtn.onclick = function() {
        modal.style.display = "none";
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
