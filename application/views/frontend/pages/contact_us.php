<!-- Banner start -->
      
    <!-- Banner End -->
    <!-- contact form start-->

    <section class="ofc-hold-wrap" style="padding-top:40px !important;">
        <div class="container"> 
		   <?php if ($this->session->flashdata('msg_error')) { ?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <strong><?php echo $this->session->flashdata('msg_error'); ?></strong>
			</div>
			<?php } else if ($this->session->flashdata('msg_success')) { ?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <strong><?php echo $this->session->flashdata('msg_success'); ?></strong>
			</div>
			<?php } ?>
            <div class="contct-us-form-wrapper">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="form-section">
                            <h2 class="con-hdr"> Leave a Message</h2>
							<form id="" class="contact_us_form" action="<?php echo base_url('/cms_pages/contact_us_enquiry'); ?>" method="post">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Name" name="name" id="name" required>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Email" name="email" id="email" required>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Phone Number" name="phone" id="phone" required>
								</div>

								<div class="form-group">
								   <input type="text" class="form-control" placeholder="Subject" name="subject" id="subject" required>
								</div>
								<div class="form-group">
									<textarea class="form-control" required placeholder="Message" name="message" id="message"></textarea>
								</div>
								<button type="submit" class="btn submit-btn">Submit</button>
							</form>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="map-addrees-wrapper ">
                            <div class="address-setion">
                                <div class="address-item">
                                    <span class="icon-add"> <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    </span>
                                    <p> Serena Court, Newport Beach,<br>
                                        CA 92663 </p>
                                </div>
                                <div class="address-item">
                                    <span class="icon-add"> <i class="fa fa-phone" aria-hidden="true"></i></span>
                                    <p> <a href="tel:949 278 1971">949 278 1971</a></p>
                                </div>
                                <div class="address-item">
                                    <span class="icon-add"> <i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                    <p> <a href="mailto:officeyew@info.com">officeyew@info.com</a></p>
                                </div>
                            </div>

                            <!-- map view -->
                            <div class="map-container">
                                <iframe class="map"
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d75166.01339191338!2d-117.99580342148263!3d33.633838371054736!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80dd20124196d72d%3A0x15655b74564c7849!2sSerena%20Ct%2C%20Newport%20Beach%2C%20CA%2092663%2C%20USA!5e0!3m2!1sen!2sin!4v1606379455091!5m2!1sen!2sin"
                                    width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""
                                    aria-hidden="false" tabindex="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
<!-- contact form end-->