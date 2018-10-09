  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<div class="row">
<div class="col-md-3">

<!-- Profile Image -->
<div class="box box-primary">
<div class="box-body box-profile">
<a href="#post-modal" data-toggle="modal" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i></a>
<img class="profile-user-img img-responsive img-circle" src="<?php echo profile_img($this->session->profile_pic); ?>" alt="User profile picture" style='height: 100px;'>

<h3 class="profile-username text-center"><?php echo $this->session->name; ?></h3>
<p class="text-muted text-center"><?php echo $this->session->email; ?></p>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->

<!-- About Me Box -->
<div class="box box-primary">
<div class="box-header with-border">
<h3 class="box-title">About Me</h3>

</div>
<!-- /.box-header -->
<div class="box-body">
<strong><i class="fa fa-envelope-o margin-r-5"></i> Email</strong>
<p class="text-muted"><?php echo (!empty($user->email))? $user->email: "No email data"; ?></p>
<hr>
<strong><i class="fa fa-user margin-r-5"></i> Gender</strong>
<p class="text-muted">
<?php echo $user->gender==1?'Male':'Female'; ?>
</p>
<hr>
<strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
<p class="text-muted"><?php echo (!empty($user->address))? $user->address: "No address data"; ?></p>
<hr>
<strong><i class="fa fa-phone margin-r-5"></i> Phone</strong>
<p class="text-muted"><?php echo (!empty($user->phone))? $user->phone: "No phone number"; ?></p>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
<div class="col-md-9">
<?php
foreach ($news as $post) {
	$duration = time_elapsed_string($post->created);
	$profile = profile_img($post->profile);
	$post_img = ($post->image<>NULL)? "<img class='img-responsive pad' src='./upload/$post->image' alt='Photo'>":"";
	echo "<div class='box box-widget'>
				<div class='box-header with-border'>
				<div class='user-block'>
				<img class='img-circle' src='$profile' alt='User Image'>
				<span class='username'><a href='user/timeline/$post->user'>$post->name</a></span>
				<!-- function to view user profile-timeline -->
				<span class='description'>Shared publicly - $duration</span>
				</div>
				<!-- /.user-block -->
				<div class='box-tools'>
				<button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i>
				</button>
				<button type='button' class='btn btn-box-tool' ><i class='fa fa-times'></i>
				</button>
				</div>
				<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class='box-body'>
				<h4>$post->title</h4>
				$post_img
				<p>$post->content</p>
				<span class='pull-right text-muted'>0 comments</span>
				</div>
				<!-- /.box-body -->
				<div class='box-footer box-comments'>
				
				</div>
				<!-- /.box-footer -->
				<div class='box-footer'>
				<form class='comment-form' onsubmit='return false;'>
				<input type='hidden' name='id' value='$post->id'>
				<img class='img-responsive img-circle img-sm' src='".profile_img($this->session->profile_image)."' alt='Alt Text'>
				<div class='img-push'>
				<input type='text' name='comment' class='form-control input-sm' placeholder='Press enter to post comment'>
				</div>
				</form>
				</div>
				</div>";
}
if(isset($back) && $back == 1)
	echo "<a href='news/back' class='btn btn-warning'>Previous Page</a>";

if(isset($next) && $next == 1)
	echo "<a href='news/next' class='btn btn-primary pull-right'>Next Page</a>";


?>

</div>

<div class="modal fade" id="follows"  role="dialog">
	<div class="modal-dialog">
		<div class="box box-primary popup" >
			<div class="box-header with-border formsize">
				  <h3 class="box-title">Followers</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" title="Close Me">x</span></button>
			</div>
			<div class="modal-body" style="padding: 0px 0px 0px 0px;">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="following"  role="dialog">
	<div class="modal-dialog">
		<div class="box box-primary popup" >
			<div class="box-header with-border formsize">
				  <h3 class="box-title">Followings</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" title="Close Me">x</span></button>
			</div>
			<div class="modal-body" style="padding: 0px 0px 0px 0px;">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="post-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">New Timeline Post</h4>
			</div>
			<form action="admin/addPost" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label>Post Title</label>
						<input type="text" name="title" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Content</label>
						<textarea class="form-control" name="content"></textarea>
					</div>
					<div class="form-group imsize">
					    <label for="upload_file">Image Upload</label>
						<input type="file" name="userfile">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Post News</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('form.comment-form').on('submit', function(){
			var elem = $(this);
			$.post('admin/add_comment', $(this).serialize(), function(response){
				location.reload();
			});
		})

                
             
		$('.cmt-delete').on('click', function(){
			var elem = $(this);
			$('#cnfrm_delete').modal('show');
			$('a.yes-btn').click(function(){
				$.get('news/delete_comment/'+elem.attr('data-id'), function(data){
					$('#cnfrm_delete').modal('hide');
					elem.closest('div.box-comment').slideUp();
				});
			});
		});

		$('.delete_post').on('click', function(){
			var elem = $(this);
			$('#cnfrm_delete').modal('show');
			$('a.yes-btn').click(function(){
				$.get('news/delete_post/'+elem.attr('data-id'), function(data){
					$('#cnfrm_delete').modal('hide');
					elem.closest('div.box-widget').slideUp();
				});
			});
		});


		<?php if($this->session->flashdata('error_flash')){?>
		ObjCommon.setErrorMsg("<?php echo $this->session->flashdata('error_flash'); ?>");
		<?php } ?>
	});
</script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
