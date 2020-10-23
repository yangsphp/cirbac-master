 <form action="#" method="post" onsubmit="return false;" id="add_produce_order_form">
	<div class="form-group">
	  <label for="batch">角色</label>
	  <select id="role_id" name="post[role_code]" class="form-control">
		<option value="">请选择角色</option>
		<?php foreach ($role as $k => $v){?>
		<option <?php if (@$data['role_code']==$v['id']){echo "selected";}?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
		<?php }?>
	</select>
	</div>
	<div class="form-group">
	  <label for="produce_total">名称</label>
	  <input name="post[username]" required placeholder="请输入管理员名称" class="form-control" type="text" value="<?php echo @$data['username']?>">
	</div>

	<div class="form-group">
	  <label for="produce_total">密码</label>
	  <input name="post[password]" required placeholder="<?php if(@$data['password']){echo '不填，则不做修改';}else{echo '请输入管理员密码';}?>" class="form-control" type="password"  value="">
	</div>
	<div class="form-group">
	  <label for="produce_total">确认密码</label>
	  <input name="post[rpassword]" required placeholder="请重复输入密码" class="form-control" type="password" value="">
	</div>
	<input type="hidden" name="id" value="<?php echo $id;?>">
</form>
<script>

</script>