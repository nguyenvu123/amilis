<?php
    $posts_json = file_get_contents('https://institut.amelis-services.com/get-blog-posts/?token=200o0z4yyshrzwzntl2df2bauvssi4i6');
    $posts = json_decode($posts_json);
?>

<section class="section section-conseils">
    <div class="container container-wide">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h2 class="underline title left underline-short"> Actualités</h2>
                <div class="include-sub-title">
                    <p class="sub-title">Nos derniers articles</p>
                    <a class="red-more" href="#">VOIR LOFFRE</a>
                </div>
                
                <div class="h-space-10"></div>
            </div>

         </div>
         <div class="row">
            <div class="blogl">

                <?php foreach ($posts as $p) : ?>

                    <div class="col-sm-4 item">
                        <span class="date"><?php echo strftime("%d %B %Y", strtotime($p->date)); ?></span>
                        <div class="blog-item">
                            <a href="<?php echo $p->url; ?>" target="_blank" class="hover-section"></a>
                            <span class="image-holder">
                                <img src="<?php echo $p->thumbnail; ?>" width="100%" alt="<?php echo $p->title; ?>">
                            </span>
                           
                          
                            <h3><a href="<?php echo $p->url; ?>" target="_blank"><?php echo $p->title; ?></a></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
