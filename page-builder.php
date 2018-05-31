<div class="page-block-container">
    <div class="page-block-wrap">
        <?php
        // Column counter, keeps foundation equalizer applying by column wrapper instead of to all columns
        $c = 1;
        // Get Page Columns
        if (have_rows('flex_page_columns')):

            while (have_rows('flex_page_columns')):
                the_row();

                // Global Row Variables
                $rowlayout = str_replace("_", "-", get_row_layout());

                // Two Column Variables
                $twoColMaxWidth = get_sub_field('total_columns_width');
                $colOneWidth = returnWidth(get_sub_field('column_one_width'));
                $colTwoWidth = returnWidth(get_sub_field('column_two_width'));

                // Col Background
                $pbcolBg = get_sub_field('column_background');

                if ($pbcolBg == "colour"):
                    $colBg = "style='background:" . get_sub_field('column_background_colour') . ";'";
                elseif ($pbcolBg == "image"):
                    $colBgImage = get_sub_field('column_background_image');
                    $colBg = "style='background-image: url(" . $colBgImage['url'] . ");'";
                elseif ($pbcolBg == "none"):
                    $colBg = "";
                endif;
                ?>
                <div class="page-column-wrap <?php echo $rowlayout; ?>" <?php echo returnWidth($twoColMaxWidth); ?> data-equalizer-mq="medium-up" data-equalizer="pbPageCols-<?php echo $c; ?>">
                    <?php if ($rowlayout == "two-page-columns"): ?>
                        <div class="col-full-wrap">
                        <?php endif; ?>

                        <?php
                        // Loop through page blocks
                        if (have_rows('page_blocks_one')):
                            ?>
                            <div class="page-column" data-equalizer-watch="pbPageCols-<?php echo $c; ?>" <?php echo $colOneWidth; ?> <?php echo $colBg; ?>>
                                <?php
                                while (have_rows('page_blocks_one')):
                                    the_row();

                                    // Get block options and set as inline style
                                    $pbblockBg = get_sub_field('block_background');
                                    $blockWidth = get_sub_field('block_width');
                                    $blockAlignment = get_sub_field('block_alignment');
                                    $blockTextColour = get_sub_field('text_colours');
                                    $blockHeadingColour = get_sub_field('heading_colours');

                                    // Block Padding
                                    $PaddingTop = get_sub_field('block_spacing_top');
                                    $blockPaddingTop = !empty($PaddingTop) ? $PaddingTop : "0";
                                    $PaddingBottom = get_sub_field('block_spacing_bottom');
                                    $blockPaddingBottom = !empty($PaddingBottom) ? $PaddingBottom : "0";
                                    $PaddingLeft = get_sub_field('block_spacing_left');
                                    $blockPaddingLeft = !empty($PaddingLeft) ? $PaddingLeft : "0";
                                    $PaddingRight = get_sub_field('block_spacing_right');
                                    $blockPaddingRight = !empty($PaddingRight) ? $PaddingRight : "0";

                                    $paddingArray = array();
                                    array_push($paddingArray, $blockPaddingTop, $blockPaddingBottom, $blockPaddingLeft, $blockPaddingRight);

                                    /* Block ID */
                                    $blockID = get_sub_field('block_identifier');
                                    $blockIdentifier = (!empty($blockID) ? "id='" . str_replace(" ", "-", strtolower($blockID)) . "'" : null);

                                    // Background
                                    if ($pbblockBg == "colour"):
                                        $colourOne = get_sub_field('background_colour');
                                        $blockBg = "style='background:" . $colourOne . ";'";
                                    elseif ($pbblockBg == "gradient"):
                                        $colourOne = get_sub_field('background_colour');
                                        $colourTwo = get_sub_field('background_colour_two');
                                        $gradAngle = get_sub_field('gradient_angle');

                                        // Background Gradients
                                        if ($gradAngle == "top-bottom"):
                                            $gradDetails = array('top', 'to bottom');
                                        elseif ($gradAngle == "left-right"):
                                            $gradDetails = array('left', 'to right');
                                        elseif ($gradAngle == "diag-top-bottom"):
                                            $gradDetails = array('-45deg', '135deg');
                                        elseif ($gradAngle == "diag-bottom-top"):
                                            $gradDetails = array('45deg', '45deg');
                                        endif;

                                        $blockBg = "style='";
                                        $blockBg .= "background:" . $colourOne . ";";
                                        $blockBg .= "background: -moz-linear-gradient(" . $gradDetails[0] . ", " . $colourOne . " 0%," . $colourTwo . " 100%);";
                                        $blockBg .= "background: -webkit-linear-gradient(" . $gradDetails[0] . ", " . $colourOne . " 0%," . $colourTwo . " 100%);";
                                        $blockBg .= "background: linear-gradient(" . $gradDetails[1] . ", " . $colourOne . " 0%," . $colourTwo . " 100%);";
                                        $blockBg .= "'";

                                    elseif ($pbblockBg == "image"):
                                        $blockBgImage = get_sub_field('background_image');
                                        $blockBg = "style='background-image: url(" . $blockBgImage['url'] . ");'";
                                    elseif ($pbblockBg == "none"):
                                        $blockBg = "";
                                    endif;

                                    // Open style string
                                    $blockStyles = "style='";

                                    // Padding
                                    if (!empty($paddingArray)):
                                        $blockStyles .= "padding:" . $blockPaddingTop . "px " . $blockPaddingRight . "px " . $blockPaddingBottom . "px " . $blockPaddingLeft . "px;";
                                    endif;

                                    // Width
                                    if (!empty($blockWidth)):
                                        $blockStyles .= " width:" . $blockWidth . "%;";
                                    endif;

                                    // Close style string
                                    $blockStyles .= "'";

                                    // Loop through primary column block content
                                    if (have_rows('page_block')):
                                        while (have_rows('page_block')):
                                            the_row();
                                            ?>
                                            <div <?php echo $blockIdentifier; ?> class="page-block" <?php echo $blockBg; ?>>
                                                <div class="content-block-wrapper builder-block-wrap <?php echo!empty($blockAlignment) ? "alignment-" . $blockAlignment : null; ?> text-clr-<?php echo $blockTextColour; ?> heading-clr-<?php echo $blockHeadingColour; ?>" <?php echo $blockStyles; ?>>

                                                    <?php
                                                    // If block type is content wysiwyg fields
                                                    if (get_row_layout() == "content_block"):
                                                        $blockContents = get_sub_field('content_block');
                                                        // Enter nested array
                                                        $contentBlocks = $blockContents[0];
                                                        // Content layout type, 1 or 2 columns
                                                        $contentLayout = $contentBlocks['acf_fc_layout'];
                                                        $blockWidths = "";
                                                        if ($contentLayout == 'two_column_content_block'):
                                                            $blockWidths = $contentBlocks['block_widths'];
                                                        endif;
                                                        // Remove layout type, so only content fields are left in array
                                                        unset($contentBlocks['acf_fc_layout'], $contentBlocks['block_widths']);
                                                        ?>
                                                        <div class="<?php echo str_replace("_", "-", $contentLayout) . " " . str_replace("_", "-", $blockWidths); ?>">
                                                            <?php foreach ($contentBlocks as $contentBlock): ?>
                                                                <div class="content-block">
                                                                    <?php echo $contentBlock; ?>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php
                                                    // If block type is a pre set module, found in /template-parts/page/blocks/
                                                    if (get_row_layout() == "pre_set_block"):
                                                        $preSetBlockFields = get_sub_field('pre_set_block');
                                                        // Pre set block selected
                                                        $preSetLayout = $preSetBlockFields[0]['acf_fc_layout'];
                                                        // Pre set block location
                                                        $BlockType = 'template-parts/page/blocks/' . str_replace("_", "-", $preSetLayout);
                                                        ?>
                                                        <div class="<?php echo str_replace("_", "-", $preSetLayout); ?>">
                                                            <?php get_template_part($BlockType); ?>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                            <?php
                                        endwhile;
                                    endif;
                                endwhile;
                                ?>
                            </div>
                            <?php
                        endif;

                        // If exists, Loop through second column block content
                        if (have_rows('page_blocks_two')):
                            ?>
                            <div class="page-column" data-equalizer-watch="pbPageCols-<?php echo $c; ?>" <?php echo $colTwoWidth; ?>>
                                <?php
                                while (have_rows('page_blocks_two')):
                                    the_row();

                                    // Inline Block Styles
                                    $blockWidth = get_sub_field('block_two_width');
                                    $blockAlignment = get_sub_field('block_two_alignment');
                                    $blockTextColourTwo = get_sub_field('text_colours');
                                    $blockHeadingColourTwo = get_sub_field('heading_colours');

                                    // Block padding
                                    $PaddingTopTwo = get_sub_field('block_spacing_top_two');
                                    $blockPaddingTopColTwo = !empty($PaddingTopTwo) ? $PaddingTopTwo : "0";
                                    $PaddingBottomTwo = get_sub_field('block_spacing_bottom_two');
                                    $blockPaddingBottomColTwo = !empty($PaddingBottomTwo) ? $PaddingBottomTwo : "0";
                                    $PaddingLeftTwo = get_sub_field('block_spacing_left_two');
                                    $blockPaddingLeftColTwo = !empty($PaddingLeftTwo) ? $PaddingLeftTwo : "0";
                                    $PaddingRightTwo = get_sub_field('block_spacing_right_two');
                                    $blockPaddingRightColTwo = !empty($PaddingRightTwo) ? $PaddingRightTwo : "0";

                                    $paddingArrayColTwo = array();
                                    array_push($paddingArrayColTwo, $blockPaddingTopColTwo, $blockPaddingBottomColTwo, $blockPaddingLeftColTwo, $blockPaddingRightColTwo);

                                    /* Block ID */
                                    $blockIDTwo = get_sub_field('block_identifier_two');
                                    $blockIdentifierTwo = (!empty($blockIDTwo) ? "id='" . str_replace(" ", "-", strtolower($blockIDTwo)) . "'" : null);

                                    // Get block background type and set as inline style
                                    $pbblockBg = get_sub_field('block_background');
                                    if ($pbblockBg == "colour"):
                                        $blockBg = "style='background:" . get_sub_field('background_colour') . ";'";
                                    elseif ($pbblockBg == "image"):
                                        $blockBgImage = get_sub_field('background_image');
                                        $blockBg = "style='background-image: url(" . $blockBgImage['url'] . ");'";
                                    endif;

                                    // Open style string
                                    $colTwoBlockStyles = "style='";

                                    // Padding
                                    if (!empty($paddingArrayColTwo)):
                                        $colTwoBlockStyles .= "padding:" . $blockPaddingTopColTwo . "px " . $blockPaddingRightColTwo . "px " . $blockPaddingBottomColTwo . "px " . $blockPaddingLeftColTwo . "px;";
                                    endif;

                                    // Width
                                    if (!empty($blockWidth)):
                                        $colTwoBlockStyles .= " width:" . $blockWidth . "%;";
                                    endif;


                                    // Close style string
                                    $colTwoBlockStyles .= "'";

                                    // Loop through block content
                                    if (have_rows('page_block')):
                                        while (have_rows('page_block')):
                                            the_row();
                                            ?>
                                            <div <?php echo $blockIdentifierTwo; ?> class="page-block" <?php echo!empty($blockBg) ? $blockBg : ""; ?>>
                                                <div class="content-block-wrapper builder-block-wrap <?php echo!empty($blockAlignment) ? "alignment-" . $blockAlignment : null; ?> text-clr-<?php echo $blockTextColourTwo; ?> heading-clr-<?php echo $blockHeadingColourTwo; ?>" <?php echo $colTwoBlockStyles; ?>>

                                                    <?php
                                                    // If block type is content wysiwyg fields
                                                    if (get_row_layout() == "content_block"):
                                                        $blockContents = get_sub_field('content_block');
                                                        // Enter nested array
                                                        $contentBlocks = $blockContents[0];
                                                        // Content layout type, 1 or 2 columns
                                                        $contentLayout = $contentBlocks['acf_fc_layout'];
                                                        $blockWidths = "";
                                                        if ($contentLayout == 'two_column_content_block'):
                                                            $blockWidths = $contentBlocks['block_widths'];
                                                        endif;
                                                        // Remove layout type, so only content fields are left in array
                                                        unset($contentBlocks['acf_fc_layout'], $contentBlocks['block_widths']);
                                                        ?>
                                                        <div class="<?php echo str_replace("_", "-", $contentLayout) . " " . str_replace("_", "-", $blockWidths); ?>">
                                                            <?php foreach ($contentBlocks as $contentBlock): ?>
                                                                <div class="content-block">
                                                                    <?php echo $contentBlock; ?>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php
                                                    // If block type is a pre set module, found in /template-parts/page/blocks/
                                                    if (get_row_layout() == "pre_set_block"):
                                                        $preSetBlockFields = get_sub_field('pre_set_block');
                                                        // Pre set block selected
                                                        $preSetLayout = $preSetBlockFields[0]['acf_fc_layout'];
                                                        // Pre set block location
                                                        $BlockType = 'template-parts/page/blocks/' . str_replace("_", "-", $preSetLayout);
                                                        ?>
                                                        <div class="pre-set-block-wrapper builder-block-wrap <?php echo str_replace("_", "-", $preSetLayout); ?>">
                                                            <?php get_template_part($BlockType); ?>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                            <?php
                                        endwhile;
                                    endif;
                                    ?>
                                    <?php
                                endwhile;
                                ?>
                            </div>
                        </div>
                        <?php
                    endif;
                    ?>
                    <?php if ($rowlayout == "two_page_columns"): ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            $c++;
        endwhile;
    endif;
    ?>
</div>
</div>
