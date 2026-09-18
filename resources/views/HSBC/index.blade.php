
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Login | VGN Payment Portal</title>

   

    <!-- CSS -->        
   <!-- FAVICONS -->
    <link
      rel="shortcut icon"
      href="https://hrms.vgn.in/assets/images/logo/favicon.png"
      type="image/png"
    />
    <link rel="icon" href="https://hrms.vgn.in/assets/images/logo/favicon.png" type="image/png" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://hrms.vgn.in/assets/css/bs-css/bootstrap.min.css" />

    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap"
      rel="stylesheet"
    />

    <!-- Bootstrap Icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <link
      href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&display=swap"
      rel="stylesheet"
    />

     <link rel="stylesheet" href="https://hrms.vgn.in/assets/css/login.css" />

  <script type="text/javascript" src="https://gc.kes.v2.scr.kaspersky-labs.com/7EA5E9BB-55E1-4C31-9C21-4943DDFED2E4/main.js?attr=GBX_1cMuIT6-qLg6OfY-lhLe0-M_qS1ZE1g4GMgO4SXYes-y80fxdEExqiBvH4UU" charset="UTF-8"></script></head>

  <body>
    <div class="login-wrapper">
      <div class="login-card">
        <div class="logo">
          <img src="https://hrms.vgn.in/assets/images/logo/logo.png" alt="Logo" />
        </div>

        <h1>Sign in</h1>
        <p class="subtitle">Continue to Payment System</p>

      <form action="{{ route('hsbc.hsbclogin') }}" autocomplete="off" id="login_form" method="post">
          @csrf
        <div class="form-group">  <input
          type="text"
          name="email"
          value=""
          class="form-control"
          placeholder="Enter Email id"
          required
          />

                </div>

      <div class="form-group">
    <input
        type="password"
        name="password"
        id="password"
        class="form-control"
        placeholder="Password"
        required
    />

    </div>

          <label class="showLabel">
            <input type="checkbox" id="show" />
            Show Password
          </label>

          
          
          <button type="submit" class="login-btn mt-5" id="loginBtn">
    <span class="btn-text">
        Sign In
    </span>

    <span class="btn-loading d-none">
        <span class="spinner-border spinner-border-sm me-2"
              role="status"
              aria-hidden="true">
        </span>

        <span id="loadingText">Signing in...</span>
    </span>
</button>
        </form>



      </div>


    </div>
   
    
  <!--Jquery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://hrms.vgn.in/assets/js/bs-js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://hrms.vgn.in/assets/js/main.js"></script>    

<script>
    $(document).ready(function () {

        /* Password Show button */
        const Password = document.querySelector("#password");
        const Checkbox = document.querySelector("#show");

        Checkbox.addEventListener("click", function () {

            const type = Password.getAttribute("type") === "password"
                ? "text"
                : "password";

            Password.setAttribute("type", type);
        });

        /* Login Loading */
        $('#login_form').on('submit', function () {

            const btn = $('#loginBtn');

            // Prevent multiple clicks
            btn.prop('disabled', true);

            // Show loading state
            btn.find('.btn-text').addClass('d-none');
            btn.find('.btn-loading').removeClass('d-none');

            // Dynamic messages
            const messages = [
                'Signing in...',
                'Verifying credentials...',
                'Please wait...',
                'Setting things up...',
                'Almost there...'
            ];

            let index = 0;

            window.loginInterval = setInterval(function () {

                index = (index + 1) % messages.length;

                $('#loadingText').text(messages[index]);

            }, 2500);

        });

    });
</script>
  </body>
</html>
