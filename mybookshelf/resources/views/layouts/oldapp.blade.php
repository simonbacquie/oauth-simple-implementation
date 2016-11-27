<!doctype html>
<html>
  <head>
    <title>Book Manager - @yield('title')</title>
    <link rel="stylesheet" type="text/css" href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel="stylesheet" type="text/css" href='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css'>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="/authors">Book Manager</a>
        </div>
        <ul class="nav navbar-nav">
          <li><a href="/authors">Authors</a></li>
          <li><a href="/authors/new">New Author</a></li>
          <li><a href="/books">Books</a></li>
          <li><a href="/books/new">New Book</a></li>
        </ul>
      </div>
    </nav>
    <div class="container">
      @yield('content')
    </div>
  </body>
</html>
