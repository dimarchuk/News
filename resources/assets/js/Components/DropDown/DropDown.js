import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import Axios from 'axios';

import {apiUrl} from "../../Helpers/index";

import './DropDown.css';

export default class DropDown extends Component {
    constructor() {
        super();

        this.state = {};
    }

    componentWillMount() {
        Axios.get(`${apiUrl}search`)
            .then(response => {
                this.setState({
                    categories: response.data.categories
                });
            })
            .catch(error => console.log(error))
    }

    render() {
        const categories = this.state.categories;

        return(
            <div className="drop-down">
                Menu
                <div className="drop-down__list">
                    <div className='level-1'>
                        <Link className='link-level-1' to={''}>Lorem</Link>
                    </div>
                    <div className='level-1'>
                        <Link className='link-level-1' to={''}>Lorem</Link>
                    </div>
                    <div className='level-1'>
                        <Link className='link-level-1' to={''}>Lorem</Link>
                    </div>
                    <div className='level-1'>
                        <span className='link-level-1'>Category</span>
                        <div className="level-2">
                            {
                                categories ? (
                                    categories.map(category => (
                                        <div key={category.id} className='level-2'>
                                            <Link to={`/category/${category.id}`}>{category.name}</Link>
                                        </div>
                                    ))
                                ) : (<p></p>)
                            }
                        </div>
                    </div>
                    <div className='level-1'>
                        <Link className='link-level-1' to={''}>Lorem</Link>
                    </div>
                    <div className='level-1'>
                        <Link className='link-level-1' to={''}>Lorem</Link>
                    </div>
                </div>
            </div>
        );
    }
}