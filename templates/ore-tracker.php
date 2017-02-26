<?php 
  get_header(); 
  wp_enqueue_style( 'sot-plugin-styles', plugins_url( 'dist/css/bundle.css', __FILE__ ), STRAYLIGHT_ORE_TRACKER_VERSION );
?>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Straylight Ore Tracker</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Ore Log</a></li>
            <li><a href="#about">About</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="jumbotron">
      <div class="container">
        <h1>Hello, Straylight Systems!</h1>
        <p>This is the Straylight Ore Tracker.</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
      </div>
    </div>

    <div class="container">

      <div class="starter-template">
        <h1>Ore Log</h1>
        <p class="lead">This is the Straylight Systems Ore Logger.<br> This is where the logger will go.</p>
      </div>

    </div><!-- /.container -->

  </body>
</html>