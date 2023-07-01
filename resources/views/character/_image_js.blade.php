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
        
        
</script>
