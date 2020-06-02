import React from 'react';
import PropTypes from 'prop-types';

const FieldSummary = props => {
    return (
        <div className="vlp-form-line vlp-link-post-required">
            <div className="vlp-form-label">
                <label htmlFor="vlp-link-summary">Summary</label>
            </div>
            <div className="vlp-form-input">
                <textarea id="vlp-link-summary" rows="3" value={props.value} onChange={props.onChangeField} ></textarea>
            </div>
            <div className="vlp-form-description">Summary for the link preview.</div>
        </div>
    );
}

FieldSummary.propTypes = {
    value: PropTypes.string.isRequired,
    onChangeField: PropTypes.func.isRequired,
}

export default FieldSummary;