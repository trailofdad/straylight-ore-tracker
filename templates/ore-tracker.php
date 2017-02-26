<?php
  get_header();
  wp_enqueue_style( 'sot-plugin-styles', plugins_url( 'dist/css/bundle.css', __FILE__ ), STRAYLIGHT_ORE_TRACKER_VERSION );
  $ore_types = [
    'Veldspar', 'Concentrated Veldspar', 'Dense Veldspar',
    'Scordite', 'Condensed Scordite', 'Massive Scordite',
    'Pyroxeres', 'Solid Pyroxeres', 'Viscous Pyroxeres',
    'Plagioclase', 'Azure Plagioclase', 'Rich Plagioclase',
    'Omber', 'Silvery Omber', 'Golden Omber',
    'Kernite', 'Luminous Kernite', 'Fiery Kernite',
    'Jaspet', 'Pure Jaspet', 'Pristine Jaspet',
    'Hemorphite', 'Vivid Hemorphite', 'Radiant Hemorphite',
    'Hedbergite', 'Vitric Hedbergite', 'Glazed Hedbergite',
    'Gneiss', 'Iridescent Gneiss', 'Prismatic Gneiss',
    'Dark Ochre', 'Onyx Ochre', 'Obsidian Ochre',
    'Spodumain', 'Bright Spodumain', 'Gleaming Spodumain',
    'Crokite', 'Sharp Crokite', 'Crystalline Crokite',
    'Arkonor', 'Crimson Arkonor', 'Prime Arkonor',
    'Bistot', 'Triclinic Bistot', 'Monoclinic Bistot',
    'Mercoxit', 'Magma Mercoxit', 'Vitreous Mercoxit'
    ];
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

    <div class="container" id="ore-log-container">

      <div class="starter-template">
        <h1>Ore Log</h1>
        <p class="lead">This is the Straylight Systems Ore Logger.<br> This is where the logger will go.</p>
      </div>

      <div>
        <button id="add-ore-type">Add Ore Type</button>
      </div>
      <div class="ore-log__wrapper">
        <div class="ore-log">
          <select name="ore-types">
            <?php
            foreach($ore_types as $ore) {
              echo '<option>' . $ore . '</option>';
            }
            ?>
          </select>
          <input type="text">
        </div>
      </div>

    </div><!-- /.container -->
    <div class="container">
      <button id="submit-ore-log">Submit Ore Log</button>
    </div>
  </body>
</html>