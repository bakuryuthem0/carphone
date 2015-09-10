@extends('layouts.default')

@section('content')
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						
					</div>
				</div>
				<div class="col-sm-12">
					<div class="blog-post-area">
						<h2 class="title text-center">Lo ultimo</h2>
						<!-- Slide -->
						<div class="single-blog-post">
							<div id="slider-carousel" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
									<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
									<li data-target="#slider-carousel" data-slide-to="1"></li>
									<li data-target="#slider-carousel" data-slide-to="2"></li>
								</ol>
								
								<div class="carousel-inner">
									<div class="item active">
										<div class="col-sm-6">
											<h1><span>E</span>-SHOPPER</h1>
											<h2>Free E-Commerce Template</h2>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
											<button type="button" class="btn btn-default get">Get it now</button>
										</div>
										<div class="col-sm-6">
											<img src="images/home/girl1.jpg" class="girl img-responsive" alt="" />
											<img src="images/home/pricing.png"  class="pricing" alt="" />
										</div>
									</div>
									<div class="item">
										<div class="col-sm-6">
											<h1><span>E</span>-SHOPPER</h1>
											<h2>100% Responsive Design</h2>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
											<button type="button" class="btn btn-default get">Get it now</button>
										</div>
										<div class="col-sm-6">
											<img src="images/home/girl2.jpg" class="girl img-responsive" alt="" />
											<img src="images/home/pricing.png"  class="pricing" alt="" />
										</div>
									</div>
									
									<div class="item">
										<div class="col-sm-6">
											<h1><span>E</span>-SHOPPER</h1>
											<h2>Free Ecommerce Template</h2>
											<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
											<button type="button" class="btn btn-default get">Get it now</button>
										</div>
										<div class="col-sm-6">
											<img src="images/home/girl3.jpg" class="girl img-responsive" alt="" />
											<img src="images/home/pricing.png" class="pricing" alt="" />
										</div>
									</div>
									
								</div>
								<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								</a>
								<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
									<i class="fa fa-angle-right"></i>
								</a>
							</div>
							<!-- End Slide -->
							
							<p>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p> <br>

							<p>
								Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p> <br>

							<p>
								Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p> <br>

							<p>
								Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
							</p>
							<div class="pager-area">
								<ul class="pager pull-right">
									<li><a href="#">Pre</a></li>
									<li><a href="#">Next</a></li>
								</ul>
							</div>
						</div>
					</div><!--/blog-post-area-->

				</div>	
			</div>
		</div>
	</section>
@stop