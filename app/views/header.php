<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visit Haarlem</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>
<style>
  body {
    margin: 0 10% 0 10%;
  }

  nav {
    display: flex;
    flex-direction: row;
    justify-content: space-around;

  }

  ul {
    list-style: none;
  }

  nav ul li {
    display: inline;
    padding-right: 20px;
    text-align: left;
  }
</style>

<body>

  <nav class="navbar">
    <a class="navbar-brand" href="/">Visit Haarlem</a>

    <ul id="leftNav">
      <li>
        <a href="/">Home</a>
      </li>
      <li>
        <a href="#">History</a>
      </li>
      <li>
        <a href="#">Culture</a>
      </li>
      <li>
        <a href="#">Food</a>
      </li>
      <li>
        <a href="#">The Festival</a>
      </li>
    </ul>
    <ul id="rightNav">
      <div class="dropdown">
        <button class="btn btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person"
            viewBox="0 0 16 16">
            <path
              d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
          </svg>
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Manage account</a></li>

        </ul>
      </div>



    </ul>

  </nav>