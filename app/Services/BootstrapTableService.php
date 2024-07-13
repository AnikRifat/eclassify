<?php

namespace App\Services;

class BootstrapTableService {
    private static string $defaultClasses = "btn icon btn-xs btn-rounded btn-icon rounded-pill";

    /**
     * @param string $iconClass
     * @param string $url
     * @param array $customClass
     * @param array $customAttributes
     * @param string $iconText
     * @return string
     */
    public static function button(string $iconClass, string $url, array $customClass = [], array $customAttributes = [], string $iconText = '') {
        $customClassStr = implode(" ", $customClass);
        $class = self::$defaultClasses . ' ' . $customClassStr;
        $attributes = '';
        if (count($customAttributes) > 0) {
            foreach ($customAttributes as $key => $value) {
                $attributes .= $key . '="' . $value . '" ';
            }
        }
        return '<a href="' . $url . '" class="' . $class . '" ' . $attributes . '><i class="' . $iconClass . '"></i>' . $iconText . '</a>&nbsp;&nbsp;';
    }

    /**
     * @param $url
     * @param bool $modal
     * @param string $dataBsTarget
     * @param null $customClass
     * @param null $id
     * @param string $iconClass
     * @param null $onClick
     * @return string
     */
    public static function editButton($url, bool $modal = false, $dataBsTarget = "#editModal", $customClass = null, $id = null, $iconClass = "fa fa-edit", $onClick = null) {
        $customClass = ["btn-primary" . " " . $customClass];
        $customAttributes = [
            "title" => trans("Edit")
        ];
        if ($modal) {
            $customAttributes = [
                "title"          => "Edit",
                "data-bs-target" => $dataBsTarget,
                "data-bs-toggle" => "modal",
                "id"             => $id,
                "onclick"        => $onClick,
            ];

            $customClass[] = "edit_btn set-form-url";
        }
        return self::button($iconClass, $url, $customClass, $customAttributes);
    }

    /**
     * @param $url
     * @param null $id
     * @param null $dataId
     * @param null $dataCategory
     * @param null $customClass
     * @return string
     */
    public static function deleteButton($url, $id = null, $dataId = null, $dataCategory = null, $customClass = null) {
        $customClass = ["delete-form", "btn-danger" . $customClass];
        $customAttributes = [
            "title"         => trans("Delete"),
            "id"            => $id,
            "data-id"       => $dataId,
            "data-category" => $dataCategory
        ];
        $iconClass = "fas fa-trash";
        return self::button($iconClass, $url, $customClass, $customAttributes);
    }

    /**
     * @param $url
     * @param string $title
     * @return string
     */
    public static function restoreButton($url, string $title = "Restore") {
        $customClass = ["btn-gradient-success", "restore-data"];
        $customAttributes = [
            "title" => trans($title),
        ];
        $iconClass = "fa fa-refresh";
        return self::button($iconClass, $url, $customClass, $customAttributes);
    }

    /**
     * @param $url
     * @return string
     */
    public static function trashButton($url) {
        $customClass = ["btn-gradient-danger", "trash-data"];
        $customAttributes = [
            "title" => trans("Delete Permanent"),
        ];
        $iconClass = "fa fa-times";
        return self::button($iconClass, $url, $customClass, $customAttributes);
    }

    public static function optionButton($url) {
        $customClass = ["btn-option"];
        $customAttributes = [
            "title" => trans("View Option Data"),
        ];
        $iconClass = "bi bi-gear";
        $iconText = " Options";
        return self::button($iconClass, $url, $customClass, $customAttributes, $iconText);
    }
}
