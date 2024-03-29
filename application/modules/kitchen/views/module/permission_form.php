<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
                    <h4 class="card-header"><?php echo html_escape((!empty($title)?$title:null)) ?></h4>
            <div class="card-body">
                <?php echo form_open("dashboard/module_permission/create/") ?>

                    <div class="form-group row">
                        <label for="blood" class="col-sm-3 col-form-label"><?php echo display('username') ?> <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <?php echo form_dropdown('fk_user_id', $user_list, $module_permission->fk_user_id, ' class="form-control"') ?> 
                        </div>
                    </div>


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('module_name') ?></th>
                                <th><?php echo display('create') ?></th>
                                <th><?php echo display('read') ?></th>
                                <th><?php echo display('update') ?></th>
                                <th><?php echo display('delete') ?></th> 
                            </tr>
                        </thead>
                        <?php $sl = 0 ?>
                        <?php if (!empty($module_list)) { ?>
                        <?php foreach ($module_list as $fk_module_id => $module_name) { ?>
                        <?php 
                            $createID = 'id="create'.$sl.'"';
                            $readID   = 'id="read'.$sl.'"';
                            $updateID = 'id="update'.$sl.'"';
                            $deleteID = 'id="delete'.$sl.'"'; 
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo ($sl+1) ?></td>
                                <td>
                                    <?php echo html_escape($module_name)?>
                                    <input type="hidden" name="fk_module_id[<?php echo $sl ?>][]" value="<?php echo html_escape($fk_module_id) ?>">
                                </td>
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <?php echo form_checkbox('create['.$sl.'][]', '1', null, $createID); ?>
                                        <label for="create<?php echo $sl ?>"></label>
                                    </div>
                                </td> 
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <?php echo form_checkbox('read['.$sl.'][]', '1', null, $readID); ?>
                                        <label for="read<?php echo $sl ?>"></label>
                                    </div>
                                </td> 
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <?php echo form_checkbox('update['.$sl.'][]', '1', null, $updateID); ?>
                                        <label for="update<?php echo $sl ?>"></label>
                                    </div>
                                </td> 
                                <td>
                                    <div class="checkbox checkbox-success text-center">
                                        <?php echo form_checkbox('delete['.$sl.'][]', '1', null, $deleteID); ?>
                                        <label for="delete<?php echo $sl ?>"></label>
                                    </div>
                                </td> 
                            </tr>
                        </tbody>
                        <?php $sl++ ?>
                        <?php } ?>
                        <?php } //endif ?>
                    </table>
         
                    <div class="form-group text-right">
                        <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                        <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                    </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>
</div>

 