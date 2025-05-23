<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);

?>
    <link rel="stylesheet" href="<?php echo CSS . 'index.css'; ?>">

    <!-- Content section -->
    <div class="content" id="content">

    </div>

    <!-- End of Content section -->


<?php

    include_once LAYOUTS . 'main_foot.php';
    setFooter($d);
?>

    <script>
        $( function(){
            app.getCitas();
            // app.lastPost();
        })
    </script>

<?php 
    closeFooter();