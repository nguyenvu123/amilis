<?php

    $testimonials = get_field('testimonials');

    if( $testimonials ): ?>

        <div class="owl-carousel testimonials-carousel">
        <?php foreach( $testimonials as $t ): // variable must NOT be called $post (IMPORTANT) ?>
            <div class="item">
                <div class="testimonial-person">
                    <div class="img-holder">
                        <img class="img-responsive" src="<?php the_field("testimonial_image", $t->ID)?>" alt="<?php echo get_the_title( $t->ID ); ?>">
                    </div>
                    <div class="testimonial-person__details">
                        <h5 class="testimonial-person__details__name"><?php echo get_the_title( $t->ID ); ?></h5>
                        <span class="testimonial-person__details__age"><?php the_field("testimonial_age_and_service", $t->ID) ?></span>
                    </div>
                </div>

                <p>
                    <?php echo the_field("testimonial_text", $t->ID) ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>

<?php endif; ?>