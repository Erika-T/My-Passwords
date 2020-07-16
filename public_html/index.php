<?php

// user list

require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Index();

$app->run();

?>

<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>Home</title>
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <link rel="stylesheet" href="css/styles.css">
      <link rel="stylesheet" href="css/styles_medium.css" media="(max-width:768px)">
      <link rel="stylesheet" href="css/styles_small.css" media="(max-width:425px)">
      <script src="https://unpkg.com/react@16/umd/react.development.js"></script>
      <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
      <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">
    </head>

    <body>

      <div class="mask">
          <div id="root"></div>
      </div>

      <script type="text/babel">
        (() => {
            // function ====================================================================
            // GlobalNav
            function GlobalNav() {
                return (
                    <nav>
                        <ul>
                            <li><a href="">ITEM1</a></li>
                            <li><a href="">ITEM2</a></li>
                            <li><a href="">ITEM3</a></li>
                            <li><a href="">ITEM4</a></li>
                        </ul>
                    </nav>
                );
            }
            
            // Header
            // function Header(props) {
            function Header() {
                // const remaining = props.items.filter(item => {
                //     return !item.isChecked;
                // });
                return (
                    <div>
                        <header>
                            <h1>My Passwords</h1>
                            <form className="search_form">
                                <input type="text" id="search" placeholder="Search"/>
                            </form>
                            <div className="user_info">
                                <i className="fas fa-user-circle"></i>
                                <p><?= h($app->me()->email); ?></p>
                                <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>"/>
                                <i className="fas fa-caret-down user_info_open"></i>
                            </div>
                            {
                                // <span>({remaining.length}/{props.items.length})</span>//
                            }
                        </header>
                        <div className="user_info_dropdown hidden">
                            <ul>
                                <li><i className="fas fa-user-circle"></i><?= h($app->me()->email); ?></li>
                                <li><i className="fas fa-sign-out-alt"></i> <input type="submit" value="Logout"/></li>
                            </ul>
                        </div>
                    </div>
                );
            }

            // Item
            function Item(props) {
                return (
                    <div className="item">
                        <div className="item_check">
                            <span className="item_check_bg"></span>
                            <input type="checkbox"
                                checked={props.item.isChecked}
                                onChange={() => props.checkItem(props.item)}
                            />
                        </div>
                        <li key={props.item.id}>
                            <label>
                                <span>
                                    {props.item.title}
                                </span>
                            </label>
                        </li>
                        <span className="cmd edit_btn"><i className="fas fa-edit"></i></span>
                        <span className="cmd delete_btn" onClick={() => props.deleteItem(props.item)}><i className="fas fa-trash-alt"></i></span>
                    </div>
                );
            }

            // ItemList
            function ItemList(props) {
                const items = props.items.map(item => {
                    return (
                        <Item
                            key={item.id}
                            item={item}
                            checkItem={props.checkItem}
                            deleteItem={props.deleteItem}
                        />
                    );
                });
                return (
                    <main>
                        <div className="category">
                            {props.items.length ? <p>All Items</p> : <p></p>}
                            <button onClick={props.purge} className="btn purge">Purge</button>
                        </div>
                        <ul className="items">
                            {props.items.length ? items : <p>No Password Yet</p>}
                        </ul>
                    </main>
                );
            }

            // NewItemForm
            function NewItemForm(props) {
                return (
                    <form onSubmit={props.addItem}>
                        <div id="modal_newItem" className="modal">
                            <div className="modal_bg js_modal_close"></div>
                            <div className="modal_content">
                                <div className="modal_header">
                                    <p>Add New Password</p>
                                    <span className="js_modal_close"><i className="fas fa-times"></i></span>
                                </div>
                                <div className="modal_inputs">
                                    <div className="wideColumn">
                                        <label>URL:</label>
                                        <input type="text" name="url" id="url" value={props.url} onChange={props.handleChange}/>
                                    </div>
                                    <div className="flex">
                                        <div>
                                            <label>Name:</label>
                                            <input type="text" name="name" id="name" value={props.name} onChange={props.handleChange}/>
                                        </div>
                                        <div>
                                            <label>Folder:</label>
                                            <input type="text" name="folder" id="folder" value={props.folder} onChange={props.handleChange}/>
                                        </div>
                                    </div>
                                    <div className="flex">
                                        <div>
                                            <label>User Name:</label>
                                            <input type="text" name="username" id="username" value={props.username} onChange={props.handleChange}/>
                                        </div>
                                        <div className="pw_input">
                                            <label>Password:</label>
                                            <input type="password" name="pw" id="pw" value={props.pw} onChange={props.handleChange}/>
                                            <span className="showPw"></span>
                                        </div>
                                    </div>
                                    <div className="wideColumn">
                                        <label>Notes:</label>
                                        <textarea type="text" name="notes" id="notes" rows="7" value={props.notes} onChange={props.handleChange}></textarea>
                                    </div>
                                    <div className="modal_btns">
                                        <button type="button" className="btn js_modal_close">Cancel</button>
                                        <button type="submit" className="btn js_modal_add">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                );
            }

            function EditItem(props) {
                return (
                    <div key={props.item.id}>
                        <div id="modal_editItem" className="modal">
                            <div className="modal_bg js_modal_close"></div>
                            <div className="modal_content">
                                <div className="modal_header">
                                    <p>Edit Password</p>
                                    <span className="js_modal_close"><i className="fas fa-times"></i></span>
                                </div>
                                <div className="modal_inputs">
                                    <div className="wideColumn">
                                        <label>URL:</label>
                                        <input type="text" name="url" id="url" value={props.item.url} onChange={props.handleChange}/>
                                    </div>                                    
                                    <div className="flex">
                                        <div>
                                            <label>Name:</label>
                                            <input type="text" name="name" id="name" value={props.item.title} onChange={props.handleChange}/>
                                        </div>
                                        <div>
                                            <label>Folder:</label>
                                            <input type="text" name="folder" id="folder" value={props.item.folder} onChange={props.handleChange}/>
                                        </div>
                                    </div>
                                    <div className="flex">
                                        <div>
                                            <label>User Name:</label>
                                            <input type="text" name="username" id="username" value={props.item.username} onChange={props.handleChange}/>
                                        </div>
                                        <div className="pw_input">
                                            <label>Password:</label>
                                            <input type="password" name="pw" id="pw" value={props.item.pw} onChange={props.handleChange}/>
                                            <span className="showPw"></span>
                                        </div>
                                    </div>
                                    <div className="wideColumn">
                                        <label>Notes:</label>
                                        <textarea type="text" name="notes" id="notes" rows="7" value={props.item.notes} onChange={props.handleChange}></textarea>
                                    </div>
                                    <div className="modal_btns">
                                        <button type="button" className="btn js_modal_close">Cancel</button>
                                        <button type="submit" className="btn js_modal_add">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                );
            }

            // EditForm need to fix!!!!
            function EditForm(props) {
                const items = props.items.map(item => {
                    return (
                        <EditItem
                            key={item.id}
                            item={item}
                        />
                    );
                });
                    return(
                        <form onSubmit={props.addItem}>{items}</form>
                    );
            }
            // ====================================================================================================

            // getUniqueId
            function getUniqueId() {
                return new Date().getTime().toString(36) + '-' + Math.random().toString(36);
            }

            // App Component (state) ====================================================================
            class App extends React.Component {
                constructor(props) {
                    super(props);
                    this.state = {
                        items: [],
                        url: "",
                        name: "",
                        folder: "",
                        username: "",
                        pw: "",
                        notes: "",
                        selectedId: -1
                    };
                    this.checkItem = this.checkItem.bind(this);
                    this.deleteItem = this.deleteItem.bind(this);
                    this.handleChange = this.handleChange.bind(this);
                    this.addItem = this.addItem.bind(this);
                    this.purge = this.purge.bind(this);
                }

                purge(e) {
                    e.preventDefault();
                    swal({
                        title: "Delete selected items?",
                        text: "Once deleted, you will not be able to recover these items!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            const items = this.state.items.filter(item => {
                                return !item.isChecked;
                            });
                            this.setState({
                                items: items
                            });
                            swal("Selected items have been deleted!", {
                                icon: "success",
                            });
                        } else {
                            swal("Selected items are safe!");
                            return;
                        }
                    });
                }

                handleChange = (e) => {
                    this.setState({
                        [e.target.name]:e.target.value //name = input name attr
                    });
                }

                addItem(e) {
                    e.preventDefault();

                    if (this.state.name.trim() === "") {
                        swal("Please Enter Name");
                        return;
                    }

                    const newitem = {
                        id: getUniqueId(),
                        title: this.state.name,
                        url: this.state.url,
                        folder: this.state.folder,
                        username: this.state.username,
                        pw: this.state.pw,
                        notes: this.state.notes,
                        isChecked: false
                    };

                    const items = this.state.items.slice();
                    items.push(newitem);
                    this.setState({
                        items: items,
                        url: "",
                        name:"",
                        folder: "",
                        username: "",
                        pw: "",
                        notes: ""
                    });
                }

                deleteItem(item) {
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this item!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true
                    }).then((willDelete) => {
                        if (willDelete) {
                            const items = this.state.items.slice();
                            const pos = this.state.items.indexOf(item);

                            items.splice(pos, 1);
                            this.setState({
                                items: items
                            });
                            swal("This item has been deleted!", {
                                icon: "success",
                            });
                        } else {
                            swal("This item is safe!");
                            return;
                        }
                    });
                }

                checkItem(item) {
                    const items = this.state.items.map(item => {
                        return {
                            id: item.id,
                            title: item.title,
                            url: item.url,
                            folder: item.folder,
                            username: item.username,
                            pw: item.pw,
                            notes: item.notes, 
                            isChecked: item.isChecked
                        };
                    });

                    const pos = this.state.items.map(item => {
                        return item.id;
                    }).indexOf(item.id);

                    items[pos].isChecked = !items[pos].isChecked;
                    this.setState({
                        items: items
                    });
                }

                componentDidUpdate() {
                    localStorage.setItem('items', JSON.stringify(this.state.items));
                }

                componentDidMount() {
                    this.setState({
                        items: JSON.parse(localStorage.getItem('items')) || []
                    });
                }

                render() {
                    return (
                        <div className="container">
                          <form action="logout.php" method="post" id="logout">
                                <div className="hamburger">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div className="btn js_modal_open">New</div>
                                <GlobalNav/>
                                <Header
                                    // items={this.state.items}
                                />
                                <ItemList
                                    items={this.state.items}
                                    checkItem={this.checkItem}
                                    deleteItem={this.deleteItem}
                                    purge={this.purge}
                                />
                                <NewItemForm
                                    // items={this.state.items}
                                    url={this.state.url}
                                    name={this.state.name}
                                    folder={this.state.folder}
                                    username={this.state.username}
                                    pw={this.state.pw}
                                    notes={this.state.notes}
                                    handleChange={this.handleChange}
                                    addItem={this.addItem}
                                />
                                <EditForm
                                    items={this.state.items}
                                    // url={this.props.url}
                                    // name={this.props.name}
                                    // folder={this.props.folder}
                                    // username={this.props.username}
                                    // pw={this.props.pw}
                                    // notes={this.props.notes}
                                    // handleChange={this.handleChange}
                                    // addItem={this.addItem}
                                    // handleEdit={this.handleEdit}
                                    // onitemEdit={this.onitemEdit}
                                />
                            </form>
                        </div>
                    );
                }
            }

            ReactDOM.render(
                <App/>,
                document.getElementById('root')
            );
        })();
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="js/jquery.quicksearch.js" type="text/javascript"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="js/script.js"></script>

    </body>
  </html>