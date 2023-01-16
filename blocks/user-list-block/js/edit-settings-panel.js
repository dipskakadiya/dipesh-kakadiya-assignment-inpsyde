/**
 * WordPress dependencies
 */
import { InspectorControls } from "@wordpress/block-editor";
import { PanelBody, PanelRow, TextControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import metadata from "../block.json";

/**
 * The SettingsPane contains a panel with block's settings.
 * It needs block's attributes to be proxied make use of
 * attributes property and setAttributes setter.
 *
 * @param {Object} props Block properties
 * @return {WPElement} Element to render.
 */
export default function SettingsPanel(props)
{
    const { attributes, setAttributes } = props;
    const { title } = attributes;

    return (
        <InspectorControls>
          <PanelBody title = {__("General", metadata.textdomain)}>
            <PanelRow>
              <TextControl
                label = {__("Name:", metadata.textdomain)}
                help = {__("Enter Name for block.", metadata.textdomain)}
                value = {title}
                onChange = {value => {
                    setAttributes({ title: value });
                    }}
              />
            </PanelRow>
          </PanelBody>
        </InspectorControls>
    );
}
