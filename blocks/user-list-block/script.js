/**
 * Block type frontend script definition.
 * It will be enqueued both in the editor and when viewing the content on the front of the site.
 */

/**
 * Internal dependencies
 */
import "./style.scss";

const main = async() => {};

if ("loading" === document.readyState) {
  // The DOM has not yet been loaded.
    document.addEventListener("DOMContentLoaded", main);
} else {
  // The DOM has already been loaded.
    main();
}
