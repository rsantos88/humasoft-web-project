import React from 'react';
import PropTypes from 'prop-types';

const FieldTitle = props => {
    return (
        <div className="vlp-form-line vlp-link-post-required">
            <div className="vlp-form-label">
                <label htmlFor="vlp-link-title">Title</label>
            </div>
            <div className="vlp-form-input">
                <input type="text" id="vlp-link-title" value={props.value} onChange={props.onChangeField} />
            </div>
            <div className="vlp-form-description">Title for the link preview.</div>
        </div>
    );
}

FieldTitle.propTypes = {
    value: PropTypes.string.isRequired,
    onChangeField: PropTypes.func.isRequired,
}

export default FieldTitle;