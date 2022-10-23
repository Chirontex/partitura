'use strict';

/**
 * Class OnSubmitFormButtonSpinner
 * @package Partitura.Genesis.Main.Effect
 */
class OnSubmitFormButtonSpinner
{
    /** @var {string} */
    #formId;

    /** @var {string} */
    #submitButtonId;

    /**
     * @param {string} formId 
     * @param {string} submitButtonId 
     */
    constructor(formId, submitButtonId)
    {
        this.#formId = formId;
        this.#submitButtonId = submitButtonId;

        const form = document.getElementById(this.#formId);

        if (form == null)
        {
            throw new Error("Form was not found.");
        }

        form.onsubmit = () => {
            this.#applySpinner();
        };
    }

    #applySpinner = () => {
        const button = document.getElementById(this.#submitButtonId);

        if (button == null)
        {
            throw new Error("Submit button was not found.");
        }

        button.innerHTML = "";
        button.setAttribute("disabled", "true");

        const spinner = document.createElement("div");
        spinner.setAttribute("class", "spinner-grow spinner-grow-sm text-light");
        spinner.setAttribute("role", "status");

        const loading = document.createElement("span");
        loading.setAttribute("class", "visually-hidden");
        loading.innerHTML = "Loading...";

        spinner.appendChild(loading);

        button.appendChild(spinner);
    }
}

module.exports = OnSubmitFormButtonSpinner;
