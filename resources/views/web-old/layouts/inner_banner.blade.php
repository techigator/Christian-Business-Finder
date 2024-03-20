@if ($inner_banner)    
<section class="inner-banner">
        <div class="container">
            <div class="row">
                <div class="sec-heading">
                    
                    <h2>{{$inner_banner->name}}</h2>
                    <!-- <h2>(SOLUTIONS FOR THE SMARTER HOME)</h2> -->
                </div>
            </div>
        </div>
    </section>
<style>
/*.innerBanner {
    background-image: url('{{asset($inner_banner->img)}}');
}  */ 
</style>
@endif