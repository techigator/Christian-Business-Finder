@extends('web.layouts.main')
@section('content')
<section class="explore1">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="explore2 mb-5">
                    <h2>SERIES</h2>
                    <p>FIND A PROGRAM TO ACHIEVE YOUR GOALS</p>
                </div>

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-PHYSICAL-tab" data-bs-toggle="pill" data-bs-target="#pills-PHYSICAL" type="button" role="tab" aria-controls="pills-PHYSICAL" aria-selected="true">PHYSICAL HEALTH</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-MENTAL-tab" data-bs-toggle="pill" data-bs-target="#pills-MENTAL" type="button" role="tab" aria-controls="pills-MENTAL" aria-selected="false">MENTAL HEALTH</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-ENERGY-tab" data-bs-toggle="pill" data-bs-target="#pills-ENERGY" type="button" role="tab" aria-controls="pills-ENERGY" aria-selected="false">ENERGY HEALTH</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-SELF-tab" data-bs-toggle="pill" data-bs-target="#pills-SELF" type="button" role="tab" aria-controls="pills-SELF" aria-selected="false">SELF HEALTH</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-SOCIAL-tab" data-bs-toggle="pill" data-bs-target="#pills-SOCIAL" type="button" role="tab" aria-controls="pills-SOCIAL" aria-selected="false">SOCIAL HEALTH</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-CORPORATE-tab" data-bs-toggle="pill" data-bs-target="#pills-CORPORATE" type="button" role="tab" aria-controls="pills-CORPORATE" aria-selected="false">CORPORATE HEALTH</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-PHYSICAL" role="tabpanel" aria-labelledby="pills-PHYSICAL-tab">
                        <div class="row  row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-3  g-2 g-lg-3">
                            <div class="col">
                                <img src="{{asset('web/images/dash/pic1.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic2.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic3.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic4.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic5.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic6.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic7.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic8.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic9.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic10.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic11.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic12.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic13.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic14.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic15.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-MENTAL" role="tabpanel" aria-labelledby="pills-MENTAL-tab">
                        <div class="row  row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-3  g-2 g-lg-3">
                            <div class="col">
                                <img src="{{asset('web/images/dash/pic1.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic2.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic3.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic4.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic5.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic6.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-ENERGY" role="tabpanel" aria-labelledby="pills-ENERGY-tab">
                        <div class="row  row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-3  g-2 g-lg-3">
                            <div class="col">
                                <img src="{{asset('web/images/dash/pic1.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic2.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic3.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic4.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic5.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic6.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-SELF" role="tabpanel" aria-labelledby="pills-SELF-tab">
                        <div class="row  row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-3  g-2 g-lg-3">
                            <div class="col">
                                <img src="{{asset('web/images/dash/pic1.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic2.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic3.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic4.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic5.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic6.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic7.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic8.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic9.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>                        
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-SOCIAL" role="tabpanel" aria-labelledby="pills-SOCIAL-tab">
                        <div class="row  row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-3  g-2 g-lg-3">
                            <div class="col">
                                <img src="{{asset('web/images/dash/pic1.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic2.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic3.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic4.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic5.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic6.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic7.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic8.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic9.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>                         
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-CORPORATE" role="tabpanel" aria-labelledby="pills-CORPORATE-tab">
                        <div class="row  row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-3  g-2 g-lg-3">
                            <div class="col">
                                <img src="{{asset('web/images/dash/pic1.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic2.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic3.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic4.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>

                            <div class="col">
                                <img src="{{asset('web/images/dash/pic5.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic6.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic7.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic8.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic9.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic10.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic11.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>


                            <div class="col">
                                <img src="{{asset('web/images/dash/pic12.png')}}" class="img-fluid" alt="">
                                <div class="tab1">
                                    <p><i class="fa-regular fa-eye"></i>&nbsp; 255k</p>
                                    <p>ADVANCED</p>
                                    <p>243&nbsp; <i class="fa-regular fa-circle-user"></i></p>
                                </div>
                                <hr class="hr1">
                                <div class="tab2">
                                    <h4>21-DAY BARRE SCULPT</h4>
                                    <p>Emily Sferra</p>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('css')
@endsection
@section('js')
@endsection