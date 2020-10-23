 <form action="#" method="post" onsubmit="return false;" id="add_auth_form">
	<div class="form-group">
	  <label for="parent_id">菜单等级</label>
		  <select id="parent_id" name="post[parent_id]" class="form-control">
			<option value="0">顶级菜单</option>
			<?php foreach ($menu as $k => $v){?>
                <option <?php if(@$data['parent_id']==$v['id']){echo "selected";}?> value="<?php echo $v['id']?>">|--<?php echo str_repeat("--", $v['level']*2).$v['name']?></option>
                <?php }?>
		</select>
	</div>
	<div class="form-group">
	  <label for="name">名称</label>
	  <input class="form-control" type="text" id="name" value="<?php echo @$data['name']?>" name="post[name]" placeholder="请输入名称">
	</div>
	<div class="form-group">
	  <label for="url">访问路径</label>
	  <input class="form-control" type="text" id="url" value="<?php echo @$data['url']?>" name="post[url]" placeholder="请输入路径">
	</div>
	<div class="form-group">
	  <label for="icon">菜单图标</label>
	  <input class="form-control" type="text" id="icon" value="<?php echo @$data['icon']?>" name="post[icon]" placeholder="请输入图标">
	</div>
	<div class="form-group">
	  <label for="sort">排序</label>
	  <input class="form-control" type="number" min="0" id="sort" value="<?php echo isset($data['sort'])?$data['sort']:0?>" name="post[sort]" placeholder="请输入排序">
	</div>
	<div class="form-group">
		<label for="batch">是否菜单</label>
		<div class="radio">
		<label class="lyear-radio radio-primary">
			<input type="radio" name="post[is_menu]" <?php echo $data['is_menu']==1?'checked':''?> value="1"><span> 是</span>
		</label>
		</div>
		<div class="radio">
		<label class="lyear-radio radio-inline radio-primary">
		<input type="radio" name="post[is_menu]" <?php echo $data['is_menu']==0?'checked':''?> value="0"><span> 否</span>
		</label>
		</div>
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