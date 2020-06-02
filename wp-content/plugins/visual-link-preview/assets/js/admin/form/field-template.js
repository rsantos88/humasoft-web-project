import React, { Component } from 'react';
import PropTypes from 'prop-types';
import Select from 'react-select';

export default class FieldTemplate extends Component {
    componentWillMount() {
        let options = [
            {
                value: 'use_default_from_settings',
                label: 'Use Default from Settings',
            }
        ];
        for (let template in vlp_admin.templates) {
            options.push({
                value: template,
                label: vlp_admin.templates[template].name,
            });
        }

        this.options = options;
    }

    render() {
        return (
            <div className="vlp-form-line">
                <div className="vlp-form-label">
                    <label htmlFor="vlp-link-template">Template</label>
                </div>
                <div className="vlp-form-input">
                    <Select
                        id="vlp-link-template"
                        options={this.options}
                        value={this.options.filter(({value}) => value === this.props.value)}
                        onChange={(option) => this.props.onChangeField(option.value )}
                        searchable={false}
                        clearable={false}
                    />
                </div>
                <div className="vlp-form-description">
                    The template to use for the link.<br/>
                    <a href={ vlp_admin.settings_link } target="_blank">Change template styling</a>
                </div>
            </div>
        );
    }
}

FieldTemplate.propTypes = {
    value: PropTypes.string.isRequired,
    onChangeField: PropTypes.func.isRequired,
}