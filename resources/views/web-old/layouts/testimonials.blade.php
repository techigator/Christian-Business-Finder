<section class="cards1">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="cards2" data-aos="zoom-in" data-aos-duration="1500">Hear From Our Users</h2>
                <div class="row  row-cols-1 row-cols-md-4 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-4 g-2 g-lg-3 mt-5 mb-5">                  
<?php 
use App\Models\testimonials;
$testimonials = testimonials::where('is_active', 1)->get();
foreach ($testimonials as $key => $testimonial): ?>
                <div class="col cards4">
                        <div class="cards5">
                            <img src="{{asset('web/images/group8.png')}}" class="img-fluid" alt="img">
                        </div>
                        <div class="cards3">
                            <div>
                                <img src="{{asset($testimonial['img'])}}" class="img-fluid" alt="img">
                            </div>

                            <div>
                                <h6>{{$testimonial->name}}</h6>
                                {{--<p>MDS MANUFACTORING</p>--}}
                                <div class="card-body1">
                                     @for ($i = 1; $i<=$testimonial->star; $i++)
                                    <span class="fa fa-star checked"></span>
                                    @endfor
                                     @for ($i = 4; $i>=$testimonial->star; $i--)
                                    <span class="fa fa-star"></span>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <?php echo html_entity_decode($testimonial['details']) ?>

                    </div>
<?php endforeach ?>
                    

                </div>
            </div>
        </div>
    </div>
</section>