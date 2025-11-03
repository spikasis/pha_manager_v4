<?php

/**
 * CRUD Form Helper Functions
 * 
 * Common form field generators for CRUD operations
 */

if (!function_exists('form_field_text')) {
    /**
     * Generate a text input field with Bootstrap styling
     * 
     * @param string $name Field name
     * @param string $label Field label
     * @param mixed $value Field value
     * @param array $attributes Additional attributes
     * @param bool $required Is required field
     * @return string HTML
     */
    function form_field_text($name, $label, $value = '', $attributes = [], $required = false)
    {
        $defaultAttributes = [
            'class' => 'form-control',
            'id' => $name
        ];
        
        if ($required) {
            $defaultAttributes['required'] = 'required';
        }
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $requiredMark = $required ? '<span class="text-danger">*</span>' : '';
        
        return '
        <div class="form-group">
            <label for="' . $name . '" class="form-label">' . $label . ' ' . $requiredMark . '</label>
            ' . form_input($name, $value, $attributes) . '
            <div class="invalid-feedback"></div>
        </div>';
    }
}

if (!function_exists('form_field_textarea')) {
    /**
     * Generate a textarea field with Bootstrap styling
     */
    function form_field_textarea($name, $label, $value = '', $attributes = [], $required = false)
    {
        $defaultAttributes = [
            'class' => 'form-control',
            'id' => $name,
            'rows' => 3
        ];
        
        if ($required) {
            $defaultAttributes['required'] = 'required';
        }
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $requiredMark = $required ? '<span class="text-danger">*</span>' : '';
        
        return '
        <div class="form-group">
            <label for="' . $name . '" class="form-label">' . $label . ' ' . $requiredMark . '</label>
            ' . form_textarea($name, $value, $attributes) . '
            <div class="invalid-feedback"></div>
        </div>';
    }
}

if (!function_exists('form_field_select')) {
    /**
     * Generate a select dropdown field with Bootstrap styling
     */
    function form_field_select($name, $label, $options = [], $selected = '', $attributes = [], $required = false)
    {
        $defaultAttributes = [
            'class' => 'form-control',
            'id' => $name
        ];
        
        if ($required) {
            $defaultAttributes['required'] = 'required';
        }
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $requiredMark = $required ? '<span class="text-danger">*</span>' : '';
        
        // Add empty option if not required
        if (!$required && !isset($options[''])) {
            $options = ['' => '-- Επιλέξτε --'] + $options;
        }
        
        return '
        <div class="form-group">
            <label for="' . $name . '" class="form-label">' . $label . ' ' . $requiredMark . '</label>
            ' . form_dropdown($name, $options, $selected, $attributes) . '
            <div class="invalid-feedback"></div>
        </div>';
    }
}

if (!function_exists('form_field_date')) {
    /**
     * Generate a date input field with Bootstrap styling
     */
    function form_field_date($name, $label, $value = '', $attributes = [], $required = false)
    {
        $defaultAttributes = [
            'class' => 'form-control datepicker',
            'id' => $name,
            'type' => 'date'
        ];
        
        if ($required) {
            $defaultAttributes['required'] = 'required';
        }
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $requiredMark = $required ? '<span class="text-danger">*</span>' : '';
        
        return '
        <div class="form-group">
            <label for="' . $name . '" class="form-label">' . $label . ' ' . $requiredMark . '</label>
            ' . form_input($name, $value, $attributes) . '
            <div class="invalid-feedback"></div>
        </div>';
    }
}

if (!function_exists('form_field_phone')) {
    /**
     * Generate a phone input field with Bootstrap styling
     */
    function form_field_phone($name, $label, $value = '', $attributes = [], $required = false)
    {
        $defaultAttributes = [
            'class' => 'form-control phone-input',
            'id' => $name,
            'type' => 'tel',
            'maxlength' => 10,
            'pattern' => '[0-9]{10}',
            'placeholder' => '2101234567'
        ];
        
        if ($required) {
            $defaultAttributes['required'] = 'required';
        }
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $requiredMark = $required ? '<span class="text-danger">*</span>' : '';
        
        return '
        <div class="form-group">
            <label for="' . $name . '" class="form-label">' . $label . ' ' . $requiredMark . '</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                </div>
                ' . form_input($name, $value, $attributes) . '
            </div>
            <div class="invalid-feedback"></div>
        </div>';
    }
}

if (!function_exists('form_field_email')) {
    /**
     * Generate an email input field with Bootstrap styling
     */
    function form_field_email($name, $label, $value = '', $attributes = [], $required = false)
    {
        $defaultAttributes = [
            'class' => 'form-control',
            'id' => $name,
            'type' => 'email'
        ];
        
        if ($required) {
            $defaultAttributes['required'] = 'required';
        }
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $requiredMark = $required ? '<span class="text-danger">*</span>' : '';
        
        return '
        <div class="form-group">
            <label for="' . $name . '" class="form-label">' . $label . ' ' . $requiredMark . '</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                ' . form_input($name, $value, $attributes) . '
            </div>
            <div class="invalid-feedback"></div>
        </div>';
    }
}

if (!function_exists('form_field_number')) {
    /**
     * Generate a number input field with Bootstrap styling
     */
    function form_field_number($name, $label, $value = '', $attributes = [], $required = false)
    {
        $defaultAttributes = [
            'class' => 'form-control',
            'id' => $name,
            'type' => 'number'
        ];
        
        if ($required) {
            $defaultAttributes['required'] = 'required';
        }
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $requiredMark = $required ? '<span class="text-danger">*</span>' : '';
        
        return '
        <div class="form-group">
            <label for="' . $name . '" class="form-label">' . $label . ' ' . $requiredMark . '</label>
            ' . form_input($name, $value, $attributes) . '
            <div class="invalid-feedback"></div>
        </div>';
    }
}

if (!function_exists('form_field_checkbox')) {
    /**
     * Generate a checkbox field with Bootstrap styling
     */
    function form_field_checkbox($name, $label, $value = '1', $checked = false, $attributes = [])
    {
        $defaultAttributes = [
            'class' => 'form-check-input',
            'id' => $name
        ];
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        return '
        <div class="form-group">
            <div class="form-check">
                ' . form_checkbox($name, $value, $checked, $attributes) . '
                <label class="form-check-label" for="' . $name . '">
                    ' . $label . '
                </label>
            </div>
        </div>';
    }
}

if (!function_exists('form_field_radio')) {
    /**
     * Generate radio button fields with Bootstrap styling
     */
    function form_field_radio($name, $label, $options = [], $selected = '', $attributes = [])
    {
        $defaultAttributes = [
            'class' => 'form-check-input'
        ];
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $html = '<div class="form-group">';
        $html .= '<label class="form-label">' . $label . '</label><br>';
        
        foreach ($options as $value => $optionLabel) {
            $id = $name . '_' . $value;
            $isChecked = ($selected == $value);
            
            $html .= '
            <div class="form-check form-check-inline">
                ' . form_radio($name, $value, $isChecked, array_merge($attributes, ['id' => $id])) . '
                <label class="form-check-label" for="' . $id . '">
                    ' . $optionLabel . '
                </label>
            </div>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}

if (!function_exists('form_field_currency')) {
    /**
     * Generate a currency input field with Bootstrap styling
     */
    function form_field_currency($name, $label, $value = '', $attributes = [], $required = false)
    {
        $defaultAttributes = [
            'class' => 'form-control',
            'id' => $name,
            'type' => 'number',
            'step' => '0.01',
            'min' => '0'
        ];
        
        if ($required) {
            $defaultAttributes['required'] = 'required';
        }
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $requiredMark = $required ? '<span class="text-danger">*</span>' : '';
        
        return '
        <div class="form-group">
            <label for="' . $name . '" class="form-label">' . $label . ' ' . $requiredMark . '</label>
            <div class="input-group">
                ' . form_input($name, $value, $attributes) . '
                <div class="input-group-append">
                    <span class="input-group-text">€</span>
                </div>
            </div>
            <div class="invalid-feedback"></div>
        </div>';
    }
}

if (!function_exists('display_field')) {
    /**
     * Display a field in show view with consistent formatting
     */
    function display_field($label, $value, $type = 'text')
    {
        $displayValue = '';
        
        switch ($type) {
            case 'date':
                $displayValue = !empty($value) ? date('d/m/Y', strtotime($value)) : '-';
                break;
            case 'datetime':
                $displayValue = !empty($value) ? date('d/m/Y H:i', strtotime($value)) : '-';
                break;
            case 'currency':
                $displayValue = !empty($value) ? number_format($value, 2) . ' €' : '0,00 €';
                break;
            case 'boolean':
                $displayValue = $value ? '<i class="fas fa-check text-success"></i> Ναι' : '<i class="fas fa-times text-danger"></i> Όχι';
                break;
            case 'phone':
                $displayValue = !empty($value) ? '<a href="tel:' . $value . '">' . $value . '</a>' : '-';
                break;
            case 'email':
                $displayValue = !empty($value) ? '<a href="mailto:' . $value . '">' . $value . '</a>' : '-';
                break;
            default:
                $displayValue = !empty($value) ? esc($value) : '-';
        }
        
        if (empty($value) && $type !== 'boolean') {
            $displayValue = '<span class="text-muted">-</span>';
        }
        
        return '
        <div class="row record-field mb-3">
            <div class="col-sm-3">
                <div class="label">' . $label . ':</div>
            </div>
            <div class="col-sm-9">
                <div class="value ' . (empty($value) && $type !== 'boolean' ? 'empty' : '') . '">
                    ' . $displayValue . '
                </div>
            </div>
        </div>';
    }
}