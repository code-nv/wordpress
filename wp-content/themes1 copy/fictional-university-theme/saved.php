<div class="acf-map">
        <?php
        $map_location = get_field('map_location'); ?>
                <div class="marker" data-lat="<?php echo $map_location['lat']?>" data-lng="<?php echo $map_location['lng']?>">
                    <h3><?php the_title(); ?></h3>
                    <?php echo $map_location['address']?>
                </div>