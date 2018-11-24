import React from 'react';

export default class SearchForm extends React.Component {
    render() {
        return (
            <div className="form">
                <label htmlFor="s" className="form-label">Search for a summoner</label>
                <input type="text" name="s"/>
            </div>
        );
    }
}