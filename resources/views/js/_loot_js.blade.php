<script>
<<<<<<< HEAD
$( document ).ready(function() {    
    var $lootTable  = $('#lootTableBody');
    var $lootRow = $('#lootRow').find('.loot-row');
    var $itemSelect = $('#lootRowData').find('.item-select');
    var $currencySelect = $('#lootRowData').find('.currency-select');
    var $awardSelect = $('#lootRowData').find('.award-select');
    @if($showLootTables)
        var $tableSelect = $('#lootRowData').find('.table-select');
    @endif
    @if($showRaffles)
        var $raffleSelect = $('#lootRowData').find('.raffle-select');
    @endif

    $('#lootTableBody .selectize').selectize();
    attachRemoveListener($('#lootTableBody .remove-loot-button'));

    $('#addLoot').on('click', function(e) {
        e.preventDefault();
        var $clone = $lootRow.clone();
        $lootTable.append($clone);
        attachRewardTypeListener($clone.find('.reward-type'));
        attachRemoveListener($clone.find('.remove-loot-button'));
    });

    $('.reward-type').on('change', function(e) {
        var val = $(this).val();
        var $cell = $(this).parent().parent().find('.loot-row-select');

        var $clone = null;
        if(val == 'Item') $clone = $itemSelect.clone();
        else if (val == 'Currency') $clone = $currencySelect.clone();
        else if (val == 'Award') $clone = $awardSelect.clone();
        @if($showLootTables)
            else if (val == 'LootTable') $clone = $tableSelect.clone();
=======
    $(document).ready(function() {
        var $lootTable = $('#lootTableBody');
        var $lootRow = $('#lootRow').find('.loot-row');
        var $itemSelect = $('#lootRowData').find('.item-select');
        var $currencySelect = $('#lootRowData').find('.currency-select');
        @if ($showLootTables)
            var $tableSelect = $('#lootRowData').find('.table-select');
>>>>>>> 7338c1a73a47b7c9d106c5d5ec9f96a7d72e9c56
        @endif
        @if ($showRaffles)
            var $raffleSelect = $('#lootRowData').find('.raffle-select');
        @endif

        $('#lootTableBody .selectize').selectize();
        attachRemoveListener($('#lootTableBody .remove-loot-button'));

        $('#addLoot').on('click', function(e) {
            e.preventDefault();
            var $clone = $lootRow.clone();
            $lootTable.append($clone);
            attachRewardTypeListener($clone.find('.reward-type'));
            attachRemoveListener($clone.find('.remove-loot-button'));
        });

        $('.reward-type').on('change', function(e) {
            var val = $(this).val();
            var $cell = $(this).parent().parent().find('.loot-row-select');

            var $clone = null;
            if (val == 'Item') $clone = $itemSelect.clone();
            else if (val == 'Currency') $clone = $currencySelect.clone();
<<<<<<< HEAD
            else if (val == 'Award') $clone = $awardSelect.clone();
            @if($showLootTables)
=======
            @if ($showLootTables)
>>>>>>> 7338c1a73a47b7c9d106c5d5ec9f96a7d72e9c56
                else if (val == 'LootTable') $clone = $tableSelect.clone();
            @endif
            @if ($showRaffles)
                else if (val == 'Raffle') $clone = $raffleSelect.clone();
            @endif

            $cell.html('');
            $cell.append($clone);
        });

        function attachRewardTypeListener(node) {
            node.on('change', function(e) {
                var val = $(this).val();
                var $cell = $(this).parent().parent().find('.loot-row-select');

                var $clone = null;
                if (val == 'Item') $clone = $itemSelect.clone();
                else if (val == 'Currency') $clone = $currencySelect.clone();
                @if ($showLootTables)
                    else if (val == 'LootTable') $clone = $tableSelect.clone();
                @endif
                @if ($showRaffles)
                    else if (val == 'Raffle') $clone = $raffleSelect.clone();
                @endif

                $cell.html('');
                $cell.append($clone);
                $clone.selectize();
            });
        }

        function attachRemoveListener(node) {
            node.on('click', function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });
        }

    });
</script>
