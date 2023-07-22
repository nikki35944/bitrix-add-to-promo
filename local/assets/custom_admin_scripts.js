window.onload = function() {
    let adminPromotionButton = document.getElementById("btn-admin-promotional");
    let adminPromotionSelect = document.querySelector("[name=\"PROP[25][]\"]");
    let adminSaveChanges = document.getElementById("admin-save-changes");

    // 18 - значение "Да" в селекторе
    adminPromotionSelect.value == 18 ? adminPromotionButton.innerHTML = 'Убрать из акционных товаров' : adminPromotionButton.innerHTML = 'Добавить в акционный товар';
    
    adminPromotionButton.onclick = function (e) {
        e.preventDefault();
        adminSaveChanges.innerHTML = 'Требуется сохранить изменения';
        if (adminPromotionSelect.value == '') {
            adminPromotionButton.innerHTML = 'Убрать из акционных товаров';
            //18 - это значение "Да" в селекторе
            adminPromotionSelect.value = 18;
        } else if (adminPromotionSelect.value == 18) {
            adminPromotionButton.innerHTML = 'Добавить в акционный товар';
            adminPromotionSelect.value = '';
        }

    }
}