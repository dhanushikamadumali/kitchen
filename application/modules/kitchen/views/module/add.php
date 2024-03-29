<!-- Google fonts -->
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
                    <h4 class="card-header"><?php echo html_escape((!empty($title)?$title:null)) ?></h4>
            <div class="card-body">
     

                <div class="col-sm-12 thumbnail">
                    <?php echo form_open_multipart("dashboard/module/upload/", 'class="form-inline"') ?>

                        <div class="form-group">
                            <label class="form-label" for="module"><?php echo display('module') ?> (.zip | .rar | .gz)</label>
                        </div> 
                        <div class="form-group">
                            <input type="file" name="module" class="form-control">
                        </div> 
                        <div class="form-group">
                            <input type="checkbox" name="overwrite"  value="false" id="overwrite"> <label for="overwrite"><?php echo display("overwrite") ?></label>
                        </div> 
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><?php echo display('add_module') ?></button>
                        </div> 
                    <?php echo form_close() ?>
                </div>

                <div class="col-sm-12">
                    <!-- display list of module without dashboard & template -->
                    <?php
                    $path = 'application/modules/';
                    $map  = directory_map($path);
                    if (is_array($map))
                    //extract each directory 
                    foreach ($map as $key => $value) {
                        $key = str_replace("\\", '/', $key);
                        $mod = str_replace("/", '', $key);
                        //chek directory is not dashboard & template
                        if ($value != "index.html" && $key != "dashboard/" && $key != "template/") {
                            // set the default config path
                            $file = $path.$key.'config/config.php';
                            $image = $path.$key.'assets/images/thumbnail.jpg';
                            $css  = $path.$key.'assets/css/module.css';
                            $js   = $path.$key.'assets/js/module.js';
                            $db   = $path.$key.'assets/data/database.sql';
                            $delMod = ((!is_array($value) && $value!='index.html')?$value:(is_array($value)?$mod:null)); 
                            //check database.sql and config.php 
                            if (file_exists($file) && file_exists($db) && file_exists($image)) {
                                @include($file);
                            //check the setting of config.php
                            if (isset($HmvcConfig[$mod])
                                && is_array($HmvcConfig[$mod])
                                && array_key_exists('_title', $HmvcConfig[$mod])
                                && $HmvcConfig[$mod]['_title'] != ''
                                && array_key_exists('_database', $HmvcConfig[$mod])
                                && array_key_exists('_description', $HmvcConfig[$mod]) 
                                && $HmvcConfig[$mod]['_description'] != ''
                                ) {

                                //form to module 
                                echo form_open('dashboard/module/install');
                                echo form_hidden('name',$HmvcConfig[$mod]['_title']);
                                echo form_hidden('image',$image);
                                echo form_hidden('directory',$mod);
                                echo form_hidden('description',$HmvcConfig[$mod]['_description']);
                            ?>
                            <!-- display module information -->
                            <div class="col-md-3 col-sm-6">
                                <div class="thumbnail">
                                  <img src="<?php echo base_url('application/modules/'.$mod.'/assets/images/thumbnail.jpg') ?>" alt="" class="m_height_height">
                                  <div class="caption">
                                    <h3><?php echo (($HmvcConfig[$mod]['_title']!=null)?$HmvcConfig[$mod]['_title']:null) ?></h3>
                                    <p><?php echo (($HmvcConfig[$mod]['_description']!=null)?$HmvcConfig[$mod]['_description']:null) ?></p>
                                    <p>
                                        <?php 
                                        $rows = null;
                                        $rows = $this->db->select("*")
                                            ->from('module')
                                            ->where('directory', $mod)
                                            ->get(); 
                                        if ($rows->num_rows() > 0) { 
                                        ?>
                                        <a onclick="return confirm('<?php echo display("are_you_sure") ?>')"  href="<?php echo base_url("dashboard/module/uninstall/".html_escape($delMod)) ?>" class="btn btn-danger"><?php echo display("uninstall") ?></a> 
                                        <?php } else { ?>
                                            <button onclick="return confirm('<?php echo display("are_you_sure") ?>')" type="submit" class="btn btn-success" role="button"><?php echo display("install") ?></button>  
                                        <?php } ?>
                                        <a onclick="return confirm('<?php echo display("are_you_sure") ?>')" href="<?php echo base_url("dashboard/module/uninstall/".html_escape($delMod)."/delete") ?>" type="submit" class="btn btn-danger"><?php echo display("delete") ?></a>
                                    </p>
                                  </div>
                                </div>
                            </div>
                            <?php 
                                echo form_close();
                            } else {
                            ?>
                             <!-- if module config.php configuration missing -->
                            <div class="col-md-3 col-sm-6">
                                <div class="thumbnail">
                                    <h3><?php echo display("invalid_module") ?> "<?php echo html_escape($mod) ?>" </h3>
                                    <div class="caption text-danger">
                                        <h4>Missing config.php</h4> 
                                        <ul class="p_left_10px">
                                        <?php 
                                        if (isset($HmvcConfig[$mod])) {
                                            if (!array_key_exists('_title', $HmvcConfig[$mod]) || $HmvcConfig[$mod]['_title'] == null) {
                                                echo '<li>$HmvcConfig["'.$mod.'"]["_title"]</li>';
                                            }      
                                            if (!array_key_exists('_description', $HmvcConfig[$mod]) || $HmvcConfig[$mod]['_description'] == null) {
                                                echo '<li>$HmvcConfig["'.$mod.'"]["_description"]</li>';
                                            }   
                                        } else {
                                            echo '<li>$HmvcConfig["'.$mod.'"] is not define</li>';
                                        }
                                        ?>

                                            <li></li>
                                        </ul>
                                    </div>
                                    <p><a onclick="return confirm('<?php echo display("are_you_sure") ?>')" href="<?php echo base_url("dashboard/module/uninstall/".html_escape($delMod)."/delete") ?>" type="submit" class="btn btn-danger"><?php echo display("delete") ?></a></p>
                                  </div>
                                </div>
                            </div>  
                            <?php

                                }
                                // ends of check the setting of config.php

                            } else { 
                            ?>
                            <!-- if module config.php or database.sql is not found -->
                            <div class="col-md-3 col-sm-6">
                                <div class="thumbnail"> 
                                    <h3><?php echo display("invalid_module") ?> "<?php echo html_escape($delMod) ?>"</h3>
                                    <div class="caption text-danger">
                                        <h4>Missing</h4> 
                                        <ul class="padding_left_10px">
                                            <?php 
                                            if (!file_exists($file)) {
                                                echo "<li>config/config.php</li>";
                                            } 
                                            if (!file_exists($db)) {
                                                echo "<li>assets/data/database.sql</li>";
                                            }  
                                            if (!file_exists($image)) {
                                                echo "<li>assets/images/thumbnail.jpg</li>";
                                            } 
                                            if (!file_exists($css)) {
                                                echo "<li>assets/css/module.css</li>";
                                            } 
                                            if (!file_exists($js)) {
                                                echo "<li>assets/js/module.js</li>";
                                            }    
                                            ?> 
                                        </ul>
                                    </div>
                                    <p><a onclick="return confirm('<?php echo display("are_you_sure") ?>')" href="<?php echo base_url("dashboard/module/uninstall/".html_escape($delMod)."/delete") ?>" type="submit" class="btn btn-danger"><?php echo display("delete") ?></a></p>
                                </div>
                            </div>   
                    <?php 
                            }
                        }
                    }   
                    ?>
                </div> 
            </div> 
        </div>
    </div>
</div>

