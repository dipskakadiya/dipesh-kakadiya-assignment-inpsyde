/**
 * WordPress dependencies
 */
import { useBlockProps } from "@wordpress/block-editor";
import { Disabled } from "@wordpress/components";
import ServerSideRender from "@wordpress/server-side-render";
import metadata from "../block.json";

/**
 * Internal dependencies
 */
import SettingsPanel from "./edit-settings-panel";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 * @param {Object} props Block properties
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
  const { attributes } = props;

  const blockProps = useBlockProps({
    className: ""
  });

  return (
    <>
      <SettingsPanel {...props} />
      <div {...blockProps}>
        <Disabled>
          <ServerSideRender
            block={metadata.name}
            attributes={{ ...attributes }}
          />
        </Disabled>
      </div>
    </>
  );
}
