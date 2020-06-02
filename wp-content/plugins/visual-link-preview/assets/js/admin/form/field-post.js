import React, { Component } from 'react';
import PropTypes from 'prop-types';
import AsyncSelect from 'react-select/lib/Async';
import Api from '../../shared/Api';

export default class FieldPost extends Component {
    getOptions(input) {
        if (!input) {
			return Promise.resolve({ options: [] });
        }

        return Api.searchPosts(input).then(( { data } ) => {
            return data.posts_with_id;
        });
    }

    render() {
        let value = this.props.value.id === 0 ? null : this.props.value;
        return (
            <div className="vlp-form-line vlp-link-type-internal">
                <div className="vlp-form-label">
                    <label htmlFor="vlp-link-post">Post</label>
                </div>
                <div className="vlp-form-input">
                    <AsyncSelect
                        placeholder="Select a post or page"
                        noOptionsMessage={ () => 'Start typing to search...' }
                        value={value}
                        onChange={this.props.onChangeField}
                        getOptionValue={({id}) => id}
                        getOptionLabel={({text}) => text}
                        loadOptions={this.getOptions.bind(this)}
                        clearable={false}
                    />
                </div>
                <div className="vlp-form-description">The post to link to.</div>
            </div>
        );
    }
}

FieldPost.propTypes = {
    value: PropTypes.object.isRequired,
    onChangeField: PropTypes.func.isRequired,
}