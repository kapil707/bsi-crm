<div class="row">
    <div class="col-xs-12">
    	<form class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <div class="col-sm-2 text-right">
                    <label class="col-sm-12 control-label">
                        Select User Type
                    </label>
                </div>
                <div class="col-sm-10">
                    <select name="user_type" id="user_type" class="form-control" required="required" onchange="user_type_onchange()">
                        <option value="">
                            Select User Type                      	
                        </option>
                        <?php
						$user_type = $this->session->flashdata('user_type1');
						$user_id = $this->session->userdata("user_id");
						$result1 = $this->db->query("select * from tbl_user_type where user_id='$user_id' and status=1")->result();
                        foreach($result1 as $row1)
                        {
                            ?>
                            <option value="<?= $row1->id; ?>"
                            <?php if($row1->id==$user_type){ echo "selected"; } ?>>
                                <?= $row1->user_type_title; ?>               	
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group" id="page_type_div">
        		<div class="col-sm-12">
                    <div class="col-sm-6">
                        All Permission
                    </div>
                    <div class="col-sm-6">
                        Permission Of Category
                    </div>
             	</div>
           		<div class="col-sm-12">
                	<select class="form-control dual_select" multiple name="page_type[]" id="page_type">
                	<?php
					$query = $this->db->query("select * from tbl_permission_page order by page_title asc");
					$result1 = $query->result();
					foreach($result1 as $row1)
					{
						$page_type = $row1->page_type;
						$query = $this->db->query("select * from tbl_permission_settings where user_type='$user_type' and page_type='$page_type'");
						$row2 = $query->row();
						?>
						<option value="<?= $row1->page_type; ?>" <?php 
						if(!empty($row2)){
						if($row2->page_type==$row1->page_type) { echo "selected"; } }?>>
							<?= $row1->page_title; ?>
						</option>
						<?php
					}
					?>
                </select>
                </div>
            </div>
            <div class="form-group text-right">
            	<input type="submit" class="ladda-button ladda-button-demo btn btn-primary" value="Permission Set" name="Submit" onclick="return check_all_value_not_null()" /> 
            </div>
     	</form>
    </div>
</div>    
<script>
function user_type_onchange()
{
	var user_type = $("#user_type option:selected").val();	
	if(user_type=="")
	{
		java_alert_function("warning","Select User Type")
		$.ajax({
			type       : "POST",
			data       :  { user_type:user_type } ,
			url        : "<?= base_url()?>admin/profile_management/get_permission_settings",
			success    : function(data){
				if(data!="")
				{
					$("#page_type_div").html(data);
					$('.dual_select').bootstrapDualListbox({
					selectorMinimalHeight: 160
					});
				}					
				else
				{
					java_alert_function("error","Something Wrong")
				}
			}
		});
	}
	else
	{
		$.ajax({
			type       : "POST",
			data       :  { user_type:user_type } ,
			url        : "<?= base_url()?>admin/profile_management/get_permission_settings",
			success    : function(data){
				if(data!="")
				{
					$("#page_type_div").html(data);
					$('.dual_select').bootstrapDualListbox({
					selectorMinimalHeight: 160
					});
				}					
				else
				{
					java_alert_function("error","Something Wrong")
				}
			}
		});
	}
}
function check_all_value_not_null()
{
	var user_type = $("#user_type option:selected").val();	
	if(user_type=="")
	{
		java_alert_function("warning","Select User Type")
		return false;
	}
	/*var page_type = $("#page_type option:selected").text();	
	if(page_type=="")
	{
		java_alert_function("warning","Select Permission Page")
		return false;
	}*/
}
</script>