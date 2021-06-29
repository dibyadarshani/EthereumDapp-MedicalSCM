pragma solidity >=0.7.0 <0.9.0;

contract supplychain{
    uint public medcount=0;
    struct Medicine{
        uint medno;
        uint upc;
        string manfid;
        string distid;
        string phid;
        string facname;
        string latitude;
        string longitude;
        string medname;
        string medprice;
        string qty;
    }
    Medicine med;
    mapping (uint=>Medicine) public medicines;
    mapping (uint=>string) public mednameByNo;
    mapping (uint=>string) public medqtyByNo;
    struct state{
        bool made;
        bool packed;
        bool sold;
        bool bought;
        bool shipped;
        bool received;
    }
    mapping (uint=>state) public medstates;
    struct loctime{
        string madeloc;
        string packedloc;
        string soldloc;
        string boughtloc;
        string shippedloc;
        string receivedloc;
    }
    mapping (uint=>loctime) public history;
    function setMed(uint _upc,string memory _manfid,string memory _distid,string memory _phid,string memory _facname,string memory _latitude,string memory _longitude,string memory _medname,string memory _medprice,string memory _qty) public{
        medcount++;
        med=Medicine(medcount,_upc,_manfid,_distid,_phid,_facname,_latitude,_longitude,_medname,_medprice,_qty);
        medicines[_upc]=med;
        mednameByNo[medcount]=_medname;
        medqtyByNo[medcount]=_qty;
    }
    function getUpc() public view returns(uint){
        return(med.upc);
    }
    function setMedQtyCount(uint _cnt,string memory _newqty) public{
        medqtyByNo[_cnt]=_newqty;
    }
    function setMade(uint _upc,string memory _loctime) public{
        medstates[_upc].made=true;
        history[_upc].madeloc=_loctime;
    }
    function setPacked(uint _upc,string memory _loctime) public{
        medstates[_upc].packed=true;
        history[_upc].packedloc=_loctime;
    }
    function setSold(uint _upc,string memory _loctime) public{
        medstates[_upc].sold=true;
        history[_upc].soldloc=_loctime;
    }
    function setBought(uint _upc,string memory _loctime) public{
        medstates[_upc].bought=true;
        history[_upc].boughtloc=_loctime;
    }
    function setShipped(uint _upc,string memory _loctime) public{
        medstates[_upc].shipped=true;
        history[_upc].shippedloc=_loctime;
    }
    function setReceived(uint _upc,string memory _loctime) public{
        medstates[_upc].received=true;
        history[_upc].receivedloc=_loctime;
    }
    function getMadeLoc(uint _upc) public view returns(string memory){
        return(history[_upc].madeloc);
    }
    function getPackedLoc(uint _upc) public view returns(string memory){
        return(history[_upc].packedloc);
    }
    function getSoldLoc(uint _upc) public view returns(string memory){
        return(history[_upc].soldloc);
    }
    function getBoughtLoc(uint _upc) public view returns(string memory){
        return(history[_upc].boughtloc);
    }
    function getShippedLoc(uint _upc) public view returns(string memory){
        return(history[_upc].shippedloc);
    }
    function getReceivedLoc(uint _upc) public view returns(string memory){
        return(history[_upc].receivedloc);
    }
    function getManfId(uint _upc) public view returns(string memory){
        return(medicines[_upc].manfid);
    }
    function getDistId(uint _upc) public view returns(string memory){
        return(medicines[_upc].distid);
    }
    function getPhId(uint _upc) public view returns(string memory){
        return(medicines[_upc].phid);
    }
    function getFacName(uint _upc) public view returns(string memory){
        return(medicines[_upc].facname);
    }
    function getLatitude(uint _upc) public view returns(string memory){
        return(medicines[_upc].latitude);
    }
    function getLongitude(uint _upc) public view returns(string memory){
        return(medicines[_upc].longitude);
    }
    function getMedName(uint _upc) public view returns(string memory){
        return(medicines[_upc].medname);
    }
    function getMedPrice(uint _upc) public view returns(string memory){
        return(medicines[_upc].medprice);
    }
    function getQty(uint _upc) public view returns(string memory){
        return(medicines[_upc].qty);
    }
    
}