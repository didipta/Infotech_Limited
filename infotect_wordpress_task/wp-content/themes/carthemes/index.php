<?php get_header(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.24.2/dist/full.css" rel="stylesheet" type="text/css" />
     <script src="https://cdn.tailwindcss.com"></script>
    <title>Car list</title>
</head>
<body>
    <header>
        <div tabindex="0" class="collapse border border-base-300 bg-base-100 rounded-box"> 
            <a href="/"><div class="collapse-title text-xl font-medium">
                <h1>Workspace</h1>
                <h1>Infotech</h1></a>
            </div>
          </div>
    </header>
    <div class="text-center text-2xl py-7">
    <h1>INVENTORY</h1>
</div>
<div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-4  my-10 justify-items-center">
<?php 
         $arg=array(
            'post_type'=>'Car',
             'post_per_page' =>8
         );
         $query=new WP_Query($arg);
         
         while($query->have_posts())
         {
            $query->the_post();
          
            $title= $post->post_title;
            $postmeta=get_post_meta($post->ID);
            $price="";
            $vin="";
            foreach ($postmeta as $key=>$val)
            {
              foreach($val as $vals)
              {
                if($key=="car_vin")
                {
                  $vin= $vals;
                }
                if($key="car_price")
                {
                  $price=$vals;
                }
                
              }
            }
            

           
            ?>
    <div class="card w-96 bg-base-100 shadow-xl" style="height:450px">
        <figure class="px-10 pt-10">
          <img src="<?php the_post_thumbnail_url();?>" alt="Shoes" class="w-full"  />
        </figure>
        <div class="card-body ">
            <div class="flex justify-between">
                <div>
                    <h2 class="card-title m-2"><?php echo $title;?></h2>
                    <p class="text-sm m-2">VIN-<?php echo $vin;?> </p>
                </div>
              <div class="m-2">
                <?php echo $price;?>
              </div>
            </div>
        
            <div class="card-actions">
                <a href="/cardetailes/{{$item->id}}"><button class="btn btn-primary mx-auto my-4">Details</button></a>
              </div>
        </div>
         
         
      </div>
        <?php }
         ?>
         </div>
          

        <footer class="footer footer-center items-center p-4 bg-neutral text-neutral-content">
            <div class="items-center grid-flow-col ">
              <p>Copyright © Workspaceit - All right reserved</p>
            </div> 
          </footer>
</body>
</html>

<?php get_footer(); ?>