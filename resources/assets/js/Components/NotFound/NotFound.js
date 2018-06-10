import React, { Component } from 'react';

import './NotFound.css';

export default class NotFound extends Component {
    render() {
        return(
            <div className='not-found'>
                <div className="not-found__title">
                    <span>404 not found</span>
                </div>
            </div>
        );
    }
}