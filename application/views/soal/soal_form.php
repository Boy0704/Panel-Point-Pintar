
        <form action="<?php echo $action.'?'.param_get(); ?>" method="post">
	    <input type="hidden" name="id_paket_soal" value="<?php echo $this->input->get('id_paket_soal') ?>">
	    <div class="form-group">
            <label for="soal">Soal <?php echo form_error('soal') ?></label>
            <textarea class="form-control textarea_editor" rows="3" name="soal" id="soal" placeholder="Soal"><?php echo $soal; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="a">A <?php echo form_error('a') ?></label>
            <textarea class="form-control" rows="3" name="a" id="a" placeholder="A"><?php echo $a; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="b">B <?php echo form_error('b') ?></label>
            <textarea class="form-control" rows="3" name="b" id="b" placeholder="B"><?php echo $b; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="c">C <?php echo form_error('c') ?></label>
            <textarea class="form-control" rows="3" name="c" id="c" placeholder="C"><?php echo $c; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="d">D <?php echo form_error('d') ?></label>
            <textarea class="form-control" rows="3" name="d" id="d" placeholder="D"><?php echo $d; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="e">E <?php echo form_error('e') ?></label>
            <textarea class="form-control" rows="3" name="e" id="e" placeholder="E"><?php echo $e; ?></textarea>
        </div>
        <?php
        $id_paket_soal = $this->input->get('id_paket_soal');
        $type_soal_paket = get_data('paket_soal','id_paket_soal',$id_paket_soal,'type_soal');
         if ($type_soal_paket == 'skd'): ?>
        <div class="form-group">
            <label for="char">Type Soal</label>
            <select name="type_soal" class="form-control">
                <option value="<?php echo $type_soal ?>"><?php echo $type_soal ?></option>
                <option value="twk">twk</option>
                <option value="tiu">tiu</option>
                <option value="tkp">tkp</option>
            </select>
        </div>
        <?php endif ?>
	    <div class="form-group">
            <label for="char">Benar <?php echo form_error('benar') ?></label>
            <select name="benar" class="form-control">
                <option value="<?php echo $benar ?>"><?php echo $benar ?></option>
                <option value="a">a</option>
                <option value="b">b</option>
                <option value="c">c</option>
                <option value="d">d</option>
                <option value="e">e</option>
            </select>
        </div>
	    <div class="form-group">
            <label for="pembahasan">Pembahasan <?php echo form_error('pembahasan') ?></label>
            <textarea class="form-control textarea_editor" rows="3" name="pembahasan" id="pembahasan" placeholder="Pembahasan"><?php echo $pembahasan; ?></textarea>
        </div>
	    <input type="hidden" name="id_soal" value="<?php echo $id_soal; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('soal?'.param_get()) ?>" class="btn btn-default">Cancel</a>
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
   