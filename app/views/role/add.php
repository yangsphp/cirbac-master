 <form action="#" method="post" onsubmit="return false;" id="add_role_form">
	<div class="form-group">
	  <label for="batch">名称</label>
	  <input class="form-control" type="text" id="batch" value="<?php echo @$data['name']?>" name="post[name]" placeholder="请输入名称">
	</div>
	<div class="form-group">
	  <label for="produce_total">授权菜单</label>
	  <table>
		<?php foreach ($menu as $k => $v){?>
		<tr>
			<td>
			<label class="lyear-checkbox checkbox-inline checkbox-primary">
              <input type="checkbox" name="post[auth][]" <?php if (@in_array($v['id'], $data['auth'])){echo "checked='true'";}?> value="<?php echo $v['id']?>" onclick="selectAll(this, <?php echo $v['id']?>)"id="role_<?php echo $v['id']?>"><span><?php echo $v['name']?></span>
            </label>
			<td>
				<?php if (@$v['_child']){foreach ($v['_child'] as $k1 => $v1){?>
				<div style="line-height: 40px;">
				<label class="lyear-checkbox checkbox-inline checkbox-primary">
				  <input type="checkbox" onclick="selectOne(this, <?php echo $v['id']?>, 0)" name="post[auth][]" <?php if (@in_array($v1['id'], $data['auth'])){echo "checked='true'";}?> class="child_<?php echo $v['id']?>" data-parentid="<?php echo $v['id']?>" id="role_<?php echo $v1['id']?>" value="<?php echo $v1['id']?>"><span><?php echo $v1['name']?></span>
				</label>
					<?php if(@$v1['_child']){foreach ($v1['_child'] as $k2 => $v2){?>
						<div style="display:inline-block;margin-right:10px;">
							<label class="lyear-checkbox checkbox-inline checkbox-primary">
							  <input type="checkbox" onclick="selectOne(this, <?php echo $v['id']?>,<?php echo $v1['id']?>)" name="post[auth][]" <?php if (@in_array($v2['id'], $data['auth'])){echo "checked='true'";}?> class="child_<?php echo $v['id']?>" data-parentid="<?php echo $v1['id']?>" id="role_<?php echo $v2['id']?>" value="<?php echo $v2['id']?>"><span><?php echo $v2['name']?></span>
							</label>
						</div>
					<?php }}?>
				</div>
				<?php }}?>
			</td>
		</tr>
		<?php }?>
	  </table>
	  
	</div>
	<input type="hidden" name="id" value="<?php echo $id?>">
</form>
<script>
    function selectAll(obj, id) {
        var flag = $(obj).is(":checked");
        if (flag==true) {
            $(".child_"+id).prop("checked", true);
        }else{
            $(".child_"+id).prop("checked", false);
        }
    }

    function selectOne(obj, parent_id, pid) {
        //设置父级的选中状态
        var flag = $(".child_"+parent_id).is(":checked");
        if (flag == true) {
            $("#role_"+parent_id).prop("checked", true);
            $("#role_"+pid).prop("checked", true);
        } else{
            $("#role_"+parent_id).prop("checked", false);
            $("#role_"+pid).prop("checked", false);
        }
    }
</script>