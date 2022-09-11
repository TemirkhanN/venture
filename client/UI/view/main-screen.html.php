<?php
/** @var \TemirkhanN\Venture\Player\Player $player */
?>
<style>
    td {
        border:1px solid gray;
        padding: 5px;
        vertical-align: baseline;
    }
</style>
<script>
    function equipItem(inventorySlotPosition) {
        sendPost({action: 'EquipItem', fromSlot: inventorySlotPosition});
    }
</script>
<div>
    <h1><?=$player->name()?></h1>
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>HP</td>
                        <td><?=$player->stats()->currentHealth()?>/<?=$player->stats()->currentHealth()?></td>
                    </tr>
                    <tr>
                        <td>Attack</td>
                        <td><?=$player->stats()->attack()?></td>
                    </tr>
                    <tr>
                        <td>Defence</td>
                        <td><?=$player->stats()->defence()?></td>
                    </tr>
                    <tr>
                        <td>Gold</td>
                        <td><?=$player->gold()?></td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td colspan="8">Inventory</td>
                    </tr>
                    <tr>
                        <?php
                        $cols = 0;
                        $newRow = true;
                        foreach ($player->showInventory() as $slot) {
                            $cols++;
                            if ($cols === 1) {
                               print('<tr>');
                            }

                            if (\TemirkhanN\Venture\Character\Equipment\EquipmentItem::isEquipmentItem($slot->item)) {
                                printf('<td onclick="equipItem(%d)">%s</td>', $slot->position, $slot->item->name());
                            } else {
                                printf('<td>%s(%d)</td>', $slot->item->name(), $slot->amountOfItems);
                            }

                            if ($cols % 8 === 0) {
                                $cols = 0;
                                print('</tr>');
                            }
                        }
                        ?>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
