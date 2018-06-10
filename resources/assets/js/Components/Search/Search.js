import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import Axios from 'axios';

import { apiUrl } from "../../Helpers/index";

import './Search.css';

export default class Search extends Component {
    constructor() {
        super();

        this.state = {};

        this.searchHandler = this.searchHandler.bind(this);
    }

    searchHandler(event) {
        const requestValue = event.target.value;

        Axios.get(`${apiUrl}tags/${requestValue}`)
            .then(response => {
                this.setState({
                    tags: response.data
                });
            })
            .catch(error => console.log(error));
    }

    render() {
        const tags = this.state.tags;

        return(
            <div className="search">
                <input className='search__input' type="text" onChange={this.searchHandler}/>
                <div className="search__helper">
                    {
                        tags ? (
                            tags.map(tag => (
                                <Link className='search__link' key={tag.id} to={`/tag/${tag.id}`} onClick={this.forceUpdate}>{tag.name}</Link>
                            ))
                        ) : (<span></span>)
                    }
                </div>
            </div>
        )
    }
}