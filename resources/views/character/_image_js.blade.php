<script>
    $(document).ready(function() {
        $('.edit-features').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/traits", 'Edit Traits');
        });
        $('.edit-class').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('characters/class/edit') }}/"+$(this).data('id'), 'Edit Class');
        });
        $('.edit-credits').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/character/image') }}/"+$(this).data('id')+"/credits", 'Edit Image Credits');
        });
        $('.reupload-image').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/character/image') }}/"+$(this).data('id')+"/reupload", 'Reupload Image');
        });
        $('.active-image').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/character/image') }}/"+$(this).data('id')+"/active", 'Set Active');
        });
        $('.delete-image').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/character/image') }}/"+$(this).data('id')+"/delete", 'Delete Image');
        });
        $('.edit-stats').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url($character->is_myo_slot ? 'admin/myo/' : 'admin/character/') }}/"+$(this).data('{{ $character->is_myo_slot ? 'id' : 'slug' }}')+"/stats", 'Edit Character Stats');
        });
        $('.add-genome').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/'.($character->is_myo_slot ? 'myo' : 'character').'/') }}/{{ $character->is_myo_slot ? $character->id : $character->slug }}/genome/create", 'Add New Genome');
        });
        $('.edit-genome').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/'.($character->is_myo_slot ? 'myo' : 'character').'/') }}/{{ $character->is_myo_slot ? $character->id : $character->slug }}/genome/"+$(this).data('genome-id'), 'Edit Genome');
        });
        $('.delete-genome').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('admin/'.($character->is_myo_slot ? 'myo' : 'character').'/') }}/{{ $character->is_myo_slot ? $character->id : $character->slug }}/genome/"+$(this).data('genome-id')+"/delete", 'Delete Genome');
        });
        $('.edit-lineage').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url($character->is_myo_slot ? 'admin/myo/' : 'admin/character/') }}/"+$(this).data('{{ $character->is_myo_slot ? 'id' : 'slug' }}')+"/lineage", 'Edit Character Lineage');
        });
        $('.edit-notes').on('click', function(e) {
            e.preventDefault();
            $("div.imagenoteseditingparse").load("{{ url('admin/character/image') }}/" + $(this).data('id') + "/notes", function() {
                tinymce.init({
                    selector: '.imagenoteseditingparse .wysiwyg',
                    height: 500,
                    menubar: false,
                    convert_urls: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen spoiler',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
                    content_css: [
                        '{{ asset('css/app.css') }}',
                        '{{ asset('css/lorekeeper.css') }}'
                    ],
                    spoiler_caption: 'Toggle Spoiler',
                    target_list: false
                });
            });
            $(".edit-notes").remove();
        });
        
</script>
