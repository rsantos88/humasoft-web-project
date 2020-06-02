import React from 'react';
import PropTypes from 'prop-types';
import Select from 'react-select';

const FieldType = props => {
    const options = [
        { value: 'internal', label: 'Internal link to own post or page' },
        { value: 'external', label: 'External link' },
    ]

    return (
        <div className="vlp-form-line">
            <div className="vlp-form-label">
                <label htmlFor="vlp-link-type">Type</label>
            </div>
            <div className="vlp-form-input">
                <Select
					id="vlp-link-type"
					options={options}
					value={options.filter(({value}) => value === props.value)}
                    onChange={props.onChangeField}
                    onChange={(option) => props.onChangeField(option.value )}
                    searchable={false}
                    clearable={false}
				/>
            </div>
            <div className="vlp-form-description">Where do you want to link to.</div>
        </div>
    );
}

FieldType.propTypes = {
    value: PropTypes.string.isRequired,
    onChangeField: PropTypes.func.isRequired,
}

export default FieldType;