/**
 * Block type frontend script definition.
 * It will be enqueued both in the editor and when viewing the content on the front of the site.
 */
import apiFetch from "@wordpress/api-fetch";

/**
 * Internal dependencies
 */
import "./style.scss";

const fetchUserDetail = async userId => {
  const userDetailPath = `/json_rest/v1/user-detail/` + userId;
  return await apiFetch({ path: userDetailPath });
};

const openUserDetailPopup = () => {
  openUserDetailLoader();
  setUserDetailPopupContent("");
  const popup = document.getElementById("user-detail-popup");
  popup.classList.remove("hide");
};

const closeUserDetailPopup = () => {
  const popup = document.getElementById("user-detail-popup");
  popup.classList.add("hide");
};

const openUserDetailLoader = () => {
  const loader = document.getElementById("user-detail-popup-loader");
  loader.classList.remove("hide");
};

const closeUserDetailLoader = () => {
  const loader = document.getElementById("user-detail-popup-loader");
  loader.classList.add("hide");
};

const setUserDetailPopupContent = html => {
  // Update popup details.
  const popupContentElement = document.querySelectorAll(
    "#user-detail-popup .popup-content"
  );
  if (popupContentElement.length > 0) {
    popupContentElement[0].innerHTML = html;
  }
};

const handleUserDetailPopup = event => {
  // Make sure event.target.hash has a value before overriding default behavior
  const hash = event.target.hash;
  if (hash !== "") {
    // Prevent default anchor click behavior
    event.preventDefault();
    openUserDetailPopup();
    fetchUserDetail(hash.replace("#", "")).then(userDetail => {
      // Update popup details.
      const popupContentElement = document.querySelectorAll(
        "#user-detail-popup .popup-content"
      );
      if (popupContentElement.length > 0) {
        const template = wp.template("user-card");
        const html = template(userDetail);
        closeUserDetailLoader();
        setUserDetailPopupContent(html);
      }
    });
  } // End if
};

const main = async () => {
  window.requestIdleCallback(() => {
    // Handle user detail popup link to show user details.
    const allUsersTableLinks = document.querySelectorAll("a.user-detail-popup");
    allUsersTableLinks.forEach(usersTableLink => {
      usersTableLink.addEventListener("click", handleUserDetailPopup);
    });

    // Handle user detail popup close event.
    const popupCloseLink = document.querySelectorAll(
      "#user-detail-popup a.close-popup"
    );
    if (popupCloseLink.length > 0) {
      popupCloseLink[0].addEventListener("click", closeUserDetailPopup);
    }
  });
};

if ("loading" === document.readyState) {
  // The DOM has not yet been loaded.
  document.addEventListener("DOMContentLoaded", main);
} else {
  // The DOM has already been loaded.
  main();
}
