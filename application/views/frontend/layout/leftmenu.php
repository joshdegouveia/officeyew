<div class="sidebarInnpadd">
                        <div class="leftbar-heading account-ico">
                           <h2>YOUR <b>ACCOUNT</b></h2>       
                         </div>
                         <?php /* ?>
                        <ul class="account-menulist">
                            <li <?php if($this->uri->segment(2)=="profile"){?>class="active"<?php }?>><a href="<?php echo base_url('user/profile'); ?>">My profile</a></li>
                            <li <?php if($this->uri->segment(2)=="modifyinfo"){?>class="active"<?php }?>><a href="<?php echo base_url('user/modifyinfo'); ?>">Modify my contact information</a></li>
                            <li <?php if($this->uri->segment(2)=="cancelmember"){?>class="active"<?php }?>><a href="<?php echo base_url('user/cancelmember'); ?>">Cancel my membership</a></li>
                            <li <?php if($this->uri->segment(2)=="modifycreditcard"){?>class="active"<?php }?>><a href="<?php echo base_url('user/modifycreditcard'); ?>">Modify my credit card # or bank account #</a></li>
                            <li <?php if($this->uri->segment(2)=="paymyoutstandingbalance"){?>class="active"<?php }?>><a href="<?php echo base_url('user/paymyoutstandingbalance'); ?>">Pay my outstanding balance</a></li>
                            <li <?php if($this->uri->segment(2)=="proccedtomynewmembership"){?>class="active"<?php }?>><a href="<?php echo base_url('user/proccedtomynewmembership'); ?>">Proceed to a new membership</a></li>
                            <li <?php if($this->uri->segment(2)=="upgrade"){?>class="active"<?php }?>><a href="<?php echo base_url('user/upgrade'); ?>">Upgrade</a></li>
                            <li><a href="<?php echo base_url('user/logout'); ?>">Log out</a></li>
                        </ul><?php */ ?>
                        <ul class="account-menulist">
                            <li <?php if($this->uri->segment(2)=="profile"){?>class="active"<?php }?>><a href="<?php echo base_url('user/profile'); ?>">My profile</a></li>
                            <li <?php if($this->uri->segment(2)=="modifyinfo"){?>class="active"<?php }?>><a href="<?php echo base_url('user/modifyinfo'); ?>">Modify my contact information</a></li>
                            <li <?php if($this->uri->segment(2)=="cancelmember"){?>class="active"<?php }?>><a href="javascript:void(0)">Cancel my membership</a></li>
                            <li <?php if($this->uri->segment(2)=="modifycreditcard"){?>class="active"<?php }?>><a href="javascript:void(0)">Modify my credit card # or bank account #</a></li>
                            <li <?php if($this->uri->segment(2)=="paymyoutstandingbalance"){?>class="active"<?php }?>><a href="javascript:void(0)">Pay my outstanding balance</a></li>
                            <li <?php if($this->uri->segment(2)=="proccedtomynewmembership"){?>class="active"<?php }?>><a href="javascript:void(0)">Proceed to a new membership</a></li>
                            <li <?php if($this->uri->segment(2)=="upgrade"){?>class="active"<?php }?>><a href="javascript:void(0)">Upgrade</a></li>
                            <li><a href="<?php echo base_url('user/logout'); ?>">Log out</a></li>
                        </ul>
                    </div>