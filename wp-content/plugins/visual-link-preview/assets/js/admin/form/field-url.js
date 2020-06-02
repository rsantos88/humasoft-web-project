import React from 'react';
import PropTypes from 'prop-types';

const FieldUrl = props => {
    return (
        <div className="vlp-form-line vlp-link-type-external">
            <div className="vlp-form-label">
                <label htmlFor="vlp-link-url">Link</label>
            </div>
            <div className="vlp-form-input">
                <input type="text" id="vlp-link-url" value={props.value} onChange={props.onChangeField} />
            </div>
            <div className="vlp-form-description">URL to link to.</div>
        </div>
    );
}

FieldUrl.propTypes = {
    value: PropTypes.string.isRequired,
    onChangeField: PropTypes.func.isRequired,
}

export default FieldUrl;