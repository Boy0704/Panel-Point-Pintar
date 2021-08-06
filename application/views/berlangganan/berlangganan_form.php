
        <form action="<?php echo $action.'?'.param_get(); ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Judul <?php echo form_error('judul') ?></label>
            <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" value="<?php echo $judul; ?>" />
        </div>
	    <div class="form-group">
            <label for="detail">Detail</label>
            <textarea class="form-control textarea_editor" rows="3" name="detail" id="detail" placeholder="Detail" required><?php echo $detail; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="int">Harga <?php echo form_error('harga') ?></label>
            <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Periode </label>
            <input type="text" class="form-control" name="periode" id="periode" placeholder="Periode" value="<?php echo $periode; ?>" required/>
        </div>
	    <input type="hidden" name="id_fitur" value="<?php echo $this->input->get('id_fitur') ?>">
	    <input type="hidden" name="id_berlangganan" value="<?php echo $id_berlangganan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('berlangganan') ?>" class="btn btn-default">Cancel</a>
	</form>

<script type="text/javascript" src="assets/plugins/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
    tinymce.init({
        selector: ".textarea_editor",
        branding: false,
        plugins: [
             "advlist autolink link image lists charmap print preview hr anchor pagebreak",
             "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
             "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
       ],
       toolbar1: "undo redo | bold italic underline",
       image_advtab: true ,
       height: '300px',
       // Disable branding message, remove "Powered by TinyMCE"
      // branding: false


       external_filemanager_path:"assets/filemanager/",
       filemanager_title:"Responsive Filemanager" ,
       external_plugins: { "filemanager" : "<?php echo base_url() ?>assets/filemanager/plugin.min.js"}
   });

</script>
   